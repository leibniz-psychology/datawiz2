# --------------------------------------------------------------
# Variables
# --------------------------------------------------------------
ENV ?= local
# Paths - should not be changed without reconfiguration
# Code paths - used to detect changes or to place generated files
NPMROOT = $(shell npm bin -g)
TOOLS_DIR = ./.tools
TOOL_CONFIG_DIR = $(TOOLS_DIR)/config
SOURCE_DIR = ./source
TEST_DIR = ./tests
DOMAIN_DIR = $(SOURCE_DIR)/Domain
DEFINITION_DIR = $(DOMAIN_DIR)/Definition
ENTITY_DIR = $(DOMAIN_DIR)/Model
STATE_DIR = $(DOMAIN_DIR)/State
FIXTURES_DIR = $(STATE_DIR)/Fixtures
MIG_DIR = $(STATE_DIR)/Migrations
ASSETS = $(SOURCE_DIR)/View/Assets
# Facts --------------------------------------------------------
SERVER_RUNNING := $(shell symfony server:status | awk '/Listening/ {print 1}')

# --------------------------------------------------------------
# Developer Interface
# --------------------------------------------------------------

# Execute all commands per task in one shell, allowing for environment variables to be set for
# all following commands.
.ONESHELL:

# Those are all commands of the developer interface
# Everything under phony will run even if a file with that name exists
.PHONY: help install run status stop logs clean tests codestyle analysis database diff migrate fixtures assets

# The target used, if you call just make without any argument
.DEFAULT_GOAL := help

# If something went wrong, delete the broken parts
.DELETE_ON_ERROR:

# Thanks to Romain Gautier for his slides from symfony live 2018 providing this ->
help: ## Print this help text
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/';

##--------Developer Interface----
install: ./node_modules ./vendor .git/hooks/commit-msg .git/hooks/pre-commit assets## Install all dependencies

run: install var/data.db assets ## Start the local development server
ifneq ($(SERVER_RUNNING), 1)
	@symfony run -d npm run dev-server
	@symfony server:start -d
endif

stop: ## Stop the local development server
ifeq ($(SERVER_RUNNING), 1)
	@symfony server:stop
endif

status: ## Check if a local development server is running
	@symfony server:status

logs: ## Check the symfony cli logs
	@symfony server:log

# This should dynamically run tasks
clean: ## Remove all temporary files
	@echo "Running clean up..."
	@rm -rf vendor node_modules $(MIG_DIR)/Development/*.php $(MIG_DIR)/Test/*.php ./public/build var .php_cs.cache ./.git/hooks/pre-commit ./.git/hooks/commit-msg
	@echo "All temporary files deleted"

##--------Code Quality-----------
tests: ./vendor var/data.db assets ## Run all tests using phpunit
	@./bin/phpunit -c $(TOOL_CONFIG_DIR)/phpunit.xml.dist

codestyle: ./vendor ## Run code formatter tools (prettier, stylelint, php-cs-fixer)
	@./bin/php-cs-fixer fix $(SOURCE_DIR) $(TEST_DIR) --config $(TOOL_CONFIG_DIR)/php_cs.dist
	@npx stylelint --fix $(ASSETS)
	@npx prettier -w $(ASSETS)

##--------Symfony----------------
database: ./vendor ## Create a database and schema
	@echo "Creating new database and schema if non exists... \c"
	@./bin/console doctrine:database:create -q --if-not-exists --env=$(ENV)
	@./bin/console doctrine:schema:create -q --env=$(ENV)
	@echo "Done"

diff: ./vendor ## Create a new migration
	@echo "Creating a new migration... \c"
	@./bin/console doctrine:migrations:diff -n -q --allow-empty-diff --env=$(ENV)
	@echo "Done"

migrate: ./vendor ## Apply all migrations
	@echo "Applying migration... \c"
	@./bin/console doctrine:migrations:migrate -n -q --allow-no-migration --env=$(ENV)
	@echo "Done"

fixtures: ./vendor ## Apply fixtures
	@echo "Loading fixtures... \c"
	@./bin/console doctrine:fixture:load -n -q --env=$(ENV)
	@echo "Done"

assets: ./public/build ## Process static assets

#------------------------------------------------------------------------------

# This creates the sqlite database for development
# and applies the schema according to current entity mapping
# and loads the fixtures
var/data.db: $(ENTITY_DIR)/*/*.php $(DEFINITION_DIR)/*/*.php $(FIXTURES_DIR)/*.php
	@echo "Removing old database... \c"
	@rm -f $@
	@echo "Done"
	@echo "Creating new database and schema... \c"
	@./bin/console doctrine:database:create -q --env=local
	@./bin/console doctrine:schema:create -q --env=local
	@echo "Done"
	@echo "Loading fixtures... \c"
	@./bin/console doctrine:fixture:load -n -q --env=local
	@echo "Done"

# This builds the static assets
./public/build: $(ASSETS)/* | ./node_modules
	@echo "Running webpack... \c"
	@npm run-script dev > /dev/null 2>&1
	@echo "Done"

# Run composer install without noise
./vendor: composer.json
	@echo "Running composer... \c"
	@composer install -q
	@echo "Done"

$(NPMROOT)/pnpm:
	@echo "Pnpm not found. Installing now... \c"
	@npm install -g pnpm >/dev/null 2>&1
	@echo "Done"

# Run npm install without noise
./node_modules: $(NPMROOT)/pnpm package.json
	@echo "Running pnpm... \c"
	@pnpm install --frozen-lockfile > /dev/null 2>&1
	@echo "Done"

# Link from .tools to .git to enable hooks
./.git/hooks/commit-msg: ./.tools/hooks/commit-msg
	@echo "Linking $@ hook... \c"
	@ln -f $< $@
	@echo "Done"

./.git/hooks/pre-commit: ./.tools/hooks/pre-commit
	@echo "Linking $@ hook... \c"
	@ln -f $< $@
	@echo "Done"

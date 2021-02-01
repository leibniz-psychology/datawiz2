# --------------------------------------------------------------
# Variables
# --------------------------------------------------------------
ENV ?= local
# Paths - should not be changed without reconfiguration
# Code paths - used to detect changes or to place generated files
TOOLS_DIR = ./.tools
TOOL_CONFIG_DIR = $(TOOLS_DIR)/config
SOURCE_DIR = ./source
TEST_DIR = ./tests
DOMAIN_DIR = $(SOURCE_DIR)/Domain
ENTITY_DIR = $(DOMAIN_DIR)/Model
STATE_DIR = $(DOMAIN_DIR)/State
FIXTURES_DIR = $(STATE_DIR)/Fixtures
MIG_DIR = $(STATE_DIR)/Migrations
ASSETS = $(SOURCE_DIR)/View/Assets
# --------------------------------------------------------------
# Developer Interface
# --------------------------------------------------------------

# Don't print the commands, only their output
.SILENT: 

# Those are all commands of the developer interface
# Everything under phony will run even if a file with that name exists
.PHONY: help install local-instance development-instance production-instance clean tests codestyle analysis database diff migrate fixtures assets

# The target used, if you call just make without any argument
.DEFAULT_GOAL := help

# If something went wrong, delete the broken parts
.DELETE_ON_ERROR:

# Thanks to Romain Gautier for his slides from symfony live 2018 providing this ->
help: ## Print this help text
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/';

##--------Developer Interface----
install: | node_modules vendor .git/hooks/commit-msg .git/hooks/pre-commit ## Install all dependencies

local-instance: install var/data.db ./public/build ## Start DataWiz locally
	./bin/console cache:clear > /dev/null 2>&1
	#TODO: this should become like a watch command in the future
	symfony serve

development-instance: ## Deploy DataWiz on a development server
	echo 'smart ansible call'

production-instance: ## Deploy DataWiz to production
	echo 'smart ansible call'

# This should dynamically run tasks
clean: ## Remove all temporary files
	echo "Running clean up..."
	rm -rf vendor node_modules $(MIG_DIR)/Development/*.php $(MIG_DIR)/Test/*.php ./public/build var .php_cs.cache
	echo "All temporary files deleted"

##--------Code Quality-----------
tests: ## Run all tests using phpunit
	./bin/phpunit -c $(TOOL_CONFIG_DIR)/phpunit.xml.dist

codestyle: ## Run code formatter tools (prettier, stylelint, php-cs-fixer)
	./bin/php-cs-fixer fix $(SOURCE_DIR) $(TEST_DIR) --config $(TOOL_CONFIG_DIR)/php_cs.dist
	npx stylelint --fix $(ASSETS)
	npx prettier -w $(ASSETS)

analysis: ## Run psalm static analyzer
	./vendor/bin/psalm --config $(TOOL_CONFIG_DIR)/psalm.xml

##--------Symfony----------------
database: ## Create a database and schema
	echo "Creating new Database and Schema if non exists... \c"
	./bin/console doctrine:database:create -q --if-not-exists --env=$(ENV)
	./bin/console doctrine:schema:create -q --env=$(ENV)
	echo "Done"

diff: ## Create a new migration
	echo "Creating Migration... \c"
	./bin/console doctrine:migrations:diff -n -q --allow-empty-diff --env=$(ENV)
	echo "Done"

migrate: ## Apply all migrations
	echo "Applying Migration... \c"
	./bin/console doctrine:migrations:migrate -n -q --allow-no-migration --env=$(ENV)
	echo "Done"

fixtures: ## Apply fixtures
	echo "Loading Fixtures... \c"
	./bin/console doctrine:fixture:load -n -q --env=$(ENV)
	echo "Done"

assets: ./public/build ## Process static assets

#------------------------------------------------------------------------------------------------------------

# This creates the sqlite database for development
# and applies the schema according to current entity mapping
# and loads the fixtures
var/data.db: $(ENTITY_DIR)/*.php
	echo "Removing old database... \c"
	rm -f $@
	echo "Done"
	echo "Creating new Database and Schema... \c"
	./bin/console doctrine:database:create -q --env=local
	./bin/console doctrine:schema:create -q --env=local
	echo "Done"
	echo "Loading fixtures... \c"
	./bin/console doctrine:fixture:load -n -q --env=local
	echo "Done"

# This builds the static assets
./public/build: $(ASSETS)/*
	echo "Running Webpack... \c"
	npm run-script dev > /dev/null 2>&1
	echo "Done"

# Run composer install without noise
vendor: composer.json #
	echo "Running composer... \c"
	composer install -q
	echo "Done"

# Run npm install without noise
node_modules: package.json
	echo "Running npm... \c"
	npm install --no-audit --no-fund --no-update-notifier --no-progress > /dev/null 2>&1
	echo "Done"

# Link from .tools to .git to enable hooks
.git/hooks/commit-msg:
	echo "Linking commit-msg hook... \c"
	ln -f .tools/hooks/commit-msg $@
	echo "Done"

.git/hooks/pre-commit:
	echo "Linking pre-commit hook... \c"
	ln -f .tools/hooks/pre-commit $@
	echo "Done"
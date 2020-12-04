-include makevars
# reference to makevars within the targets
MAKEVAR_FILE = makevars
# save the name of this file - important for help target
SELF = $(firstword $(MAKEFILE_LIST))

# --------------------------------------------------------------
# Variables
# --------------------------------------------------------------

# Variable defaults - can be changed with your own makevars file

# Controls for which environment the commands run - never use prod
ENV ?= dev
# This is required with a localhost definition to run symfony cli - we should fail if it is missing
HOSTS_FILE ?= /etc/hosts
# Which inventory file will you use - a local.ini or a remote.ini
# You can create your own inventories and use them as option here
INVENTORY ?= $(ENV).ini
# Playbook used against the selected hosts found in INVENTORY
PLAYBOOK ?= $(ENV).yaml

# Paths - should not be changed without reconfiguration
# Code paths - used to detect changes or to place generated files
SOURCE_DIR = ./source
DOMAIN_DIR = $(SOURCE_DIR)/Domain
ENTITY_DIR = $(DOMAIN_DIR)/Model
STATE_DIR = $(DOMAIN_DIR)/State
FIXTURES_DIR = $(STATE_DIR)/Fixtures
MIG_DIR = $(STATE_DIR)/Migrations
DEV_STATE_DIR = $(MIG_DIR)/Development
ASSET_IN = $(SOURCE_DIR)/View/Assets
# Infrastructure as Code
ANSIBLE_DIR = ./infrastructure
INVENTORY_DIR = $(ANSIBLE_DIR)/inventory
# Output directories - not maintained by the developer
MARK_DIR = ./.markers
VAR_DIR = ./var
JS_DEPS = ./node_modules
PHP_DEPS = ./vendor
ASSET_OUT = ./public/build

# Those files signal different states of the sqlite file
SCHEMA_MARK = $(MARK_DIR)/schema
FIXTURE_MARK = $(MARK_DIR)/fixture
MIGRATION_MARK = $(MARK_DIR)/migration

ALL_DIRS = $(MARK_DIR) $(DEV_STATE_DIR) $(VAR_DIR)
TEMPORARY = $(JS_DEPS) $(PHP_DEPS) $(DEV_STATE_DIR) $(VAR_DIR) $(MARK_DIR) $(ASSET_OUT)

LOGFILE = $(VAR_DIR)/tools_log.txt

# --------------------------------------------------------------
# Developer Interface
# --------------------------------------------------------------

# Don't print the commands, only their output
.SILENT: 
# Those are all commands of the developer interface
# Everything under phony will run even if a file with that name exists
.PHONY: help debug log install run tests clean assets migrations fixtures deploy

# The target used, if you call just make without any argument
.DEFAULT_GOAL := help

# If something went wrong, delete the broken parts
.DELETE_ON_ERROR:

# Thanks to Romain Gautier for his slides from symfony live 2018 providing this ->
##-----Developer Interface-------
help: ## Print this help text
	grep -E '(^[a-zA-Z_]+:.*?##.*$$)|(^##)' $(SELF) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

debug: ## Print all information for debugging the makefile
	echo "Following is marked for the clean target: $(TEMPORARY)"
	echo "Directories made by make: $(ALL_DIRS)"

log: ## Print the logfile created by this makefile
	cat $(LOGFILE)

##-----General-------------------
install: $(ALL_DIRS) $(JS_DEPS) $(PHP_DEPS) $(FIXTURE_MARK) ## Run all tasks necessary to run

run: $(MIGRATION_MARK) $(FIXTURE_MARK) $(ASSET_OUT) $(HOSTS_FILE) ## Apply all Symfony targets and run the application
	symfony serve

tests: ## Run all tests using phpunit
	./bin/phpunit -c ./config/packages/test/phpunit.xml.dist

codestyle: ## Run code formatter tools (prettier, stylelint, php-cs-fixer)
	./bin/php-cs-fixer fix
	npx stylelint --fix $(ASSET_IN)
	npx prettier -w $(ASSET_IN)

analysis: ## Run psalm static analyzer
	./vendor/bin/psalm --config .tools/config/psalm.xml

clean: ## Remove all temporary files
	@echo "Start cleanup..."
	rm -rf $(TEMPORARY)
	@echo "This removed the following:"
	@echo $(sort $(TEMPORARY))

##-----Symfony-------------------
assets: $(ASSET_OUT) ## Compile static assets using webpack

migrations: $(MIGRATION_MARK) ## Generate and apply a doctrine migration

fixtures: $(FIXTURE_MARK) ## Apply doctrine fixtures

##-----Deployment----------------
deploy: ## Deploy this project using ansible 
	ansible-playbook $(ANSIBLE_DIR)/$(PLAYBOOK) -i $(INVENTORY_DIR)/$(INVENTORY) -K

# --------------------------------------------------------------
# Helper targets
# --------------------------------------------------------------

# run composer
$(PHP_DEPS): composer.json
	echo "Running composer... \c"
	composer install -q >> $(LOGFILE)
	echo "Done"

# run npm
$(JS_DEPS): package.json
	echo "Running npm... \c"
	npm install --no-audit --no-fund --no-update-notifier --no-progress >> $(LOGFILE)
	echo "Done"

# create all the directories needed
$(ALL_DIRS):
	echo "Creating $@... \c"
	mkdir -p $@
	echo "Done"

# rebuild static assets if the asset folder has changes
$(ASSET_OUT): $(ASSET_IN)/*
	echo "Running Webpack... \c"
	npm run-script dev >> $(LOGFILE)
	echo "Done"

# This creates the sqlite database for development and applies the schema according to current entity mapping
$(SCHEMA_MARK):
	echo "Creating new Database and Schema... \c"
	./bin/console doctrine:database:create -q --env=$(ENV) >> $(LOGFILE)
	./bin/console doctrine:schema:create -q --env=$(ENV) >> $(LOGFILE)
	touch $@
	echo "Done"

# With the schema up to date, the fixture can be loaded
# This should only rerun, if the fixture files change
$(FIXTURE_MARK): $(MIGRATION_MARK) $(FIXTURES_DIR)/*.php | $(MARK_DIR) $(SCHEMA_MARK)
	echo "Loading Fixtures... \c"
	./bin/console doctrine:fixture:load -n --env=$(ENV) >> $(LOGFILE)
	touch $@
	echo "Done"

# When your entities change, your schema needs to adapt to those changes
# This should only rerun, if your entities change
$(MIGRATION_MARK): $(ENTITY_DIR)/*.php | $(MARK_DIR) $(SCHEMA_MARK)
	echo "Apply Migrations... \c"
	./bin/console doctrine:migrations:diff -n -q --allow-empty-diff --env=$(ENV)
	./bin/console doctrine:migrations:migrate -n -q --allow-no-migration --env=$(ENV)
	touch $@
	echo "Done"


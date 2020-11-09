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
# Which inventory file will you use - a local.ini or a remote.ini
# You can create your own inventories and use them as option here
INVENTORY ?= local.ini
# Enable debug mode for some make targets
DEBUG ?= false
# IP of your local development server
LOCAL_IP ?= 0.0.0.0
# User for the ansible login (local)
LOCAL_ANSIBLE_USER ?= ansible
# IP of your remote server - this could be productions or testing
REMOTE_IP ?= 0.0.0.0
# User for the remote ansible login (remote)
REMOTE_ANSIBLE_USER ?= ansible
# The playbook that will be executed against the server 
# (valid is currently 'testing.yaml' and 'production.yaml')
PLAYBOOK ?= testing.yaml

# If you debug the makefile, set a variable VERBOSE to print all commands out
ifndef VERBOSE
.SILENT:
endif

# Paths - should not be changed without reconfiguration
# Code paths - used to detect changes or to place generated files
SOURCE_DIR = ./source
DOMAIN_DIR = $(SOURCE_DIR)/Domain
ENTITY_DIR = $(DOMAIN_DIR)/Model
STATE_DIR = $(DOMAIN_DIR)/State
FIXTURES_DIR = $(STATE_DIR)/Fixtures
MIG_DIR = $(STATE_DIR)/Migrations
DEV_STATE_DIR = $(MIG_DIR)/Development
PROD_STATE_DIR = $(MIG_DIR)/Production
TEST_STATE_DIR = $(MIG_DIR)/Test
ASSET_IN = $(SOURCE_DIR)/View/Assets/*
# Infrastructure as Code
ANSIBLE_DIR = ./infrastructure
INVENTORY_DIR = $(ANSIBLE_DIR)/inventory
# Output directories - not maintained by the developer
MARK_DIR = ./.markers
VAR_DIR = ./var
JS_DEPS = ./node_modules
PHP_DEPS = ./vendor
ASSET_OUT = ./public/build

# Files created within this makefile
REMOTE_INV = $(INVENTORY_DIR)/remote.ini
LOCAL_INV = $(INVENTORY_DIR)/local.ini

# Those files signal different states of the sqlite file
SCHEMA_MARK = $(MARK_DIR)/schema
FIXTURE_MARK = $(MARK_DIR)/fixture
MIGRATION_MARK = $(MARK_DIR)/migration


# --------------------------------------------------------------
# Developer Interface
# --------------------------------------------------------------

# Those are all commands of the developer interface
# Everything under phony will run even if a file with that name exists
.PHONY: help install run tests clean assets migrations fixtures inventories deploy

# The target used, if you call just make without any argument
.DEFAULT_GOAL := help

# Thanks to Romain Gautier for his slides from symfony live 2018 providing this ->
##-----Developer Interface-------
help: ## Show this help text
	grep -E '(^[a-zA-Z_]+:.*?##.*$$)|(^##)' $(SELF) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

##-----General-------------------
install: $(MARK_DIR) $(DEV_STATE_DIR) $(PROD_STATE_DIR) $(TEST_STATE_DIR) $(JS_DEPS) $(PHP_DEPS) $(FIXTURE_MARK) ## Setup dependencies for local development

run: $(MIGRATION_MARK) $(FIXTURE_MARK) $(ASSET_OUT) ## Apply migrations and fixtures, build assets and run the application
	symfony serve

tests: ## Run all tests
	./bin/phpunit -c ./config/packages/test/phpunit.xml.dist

codestyle: ## Run php-cs-fixer
	php-cs-fixer fix
	npx stylelint --fix $(ASSET_IN:*=)
	npx prettier -w $(ASSET_IN:*=)

clean: ## Remove all temporary files
ifeq ($(DEBUG), true)
	@echo "These files would have been removed - disable debuging to delete them"
else
	@echo "Start cleanup..."
	rm -rf $(JS_DEPS) $(PHP_DEPS) $(DEV_STATE_DIR) $(VAR_DIR) $(MARK_DIR) $(INVENTORY_DIR) $(ASSET_OUT)
	@echo "This removed the following:"
endif
	@echo $(JS_DEPS) # npm dependencies
	@echo $(PHP_DEPS) # composer dependencies
	@echo $(DEV_STATE_DIR) # all migrations (only for development!)
	@echo $(VAR_DIR) # all temporary symfony app data
	@echo $(MARK_DIR) # state-tracker files
	@echo $(INVENTORY_DIR) # generated inventories
	@echo $(ASSET_OUT) # static asset output

##-----Symfony-------------------
assets: $(ASSET_OUT) ## Compile static assets

migrations: $(MIGRATION_MARK) ## Generate and apply a doctrine migration

fixtures: $(FIXTURE_MARK) ## Apply doctrine fixtures

##-----Deployment----------------
inventories: $(LOCAL_INV) $(REMOTE_INV) ## Create your ansible inventories according to your makevars

deploy: $(LOCAL_INV) $(REMOTE_INV) ## Deploy this project with ansible 
	ansible-playbook $(ANSIBLE_DIR)/$(PLAYBOOK) -i $(INVENTORY_DIR)/$(INVENTORY) -K

# --------------------------------------------------------------
# Plumber targets
# --------------------------------------------------------------

# run composer
$(PHP_DEPS): composer.json
	@echo "Installing Php dependencies... \c"
	composer install -q
	@echo "Done"

# run npm
$(JS_DEPS): package.json
	@echo "Installing NodeJS dependencies... \c"
	npm install --silent --no-audit --no-fund --no-update-notifier --no-progress > /dev/null
	@echo "Done"

# create the directory needed
$(MARK_DIR):
	@echo "Creating $@... \c"
	mkdir -p $@
	@echo "Done"

# see above
$(DEV_STATE_DIR):
	@echo "Creating $@... \c"
	mkdir -p $@
	@echo "Done"

# see above
$(TEST_STATE_DIR):
	@echo "Creating $@... \c"
	mkdir -p $@
	@echo "Done"

# see above
$(PROD_STATE_DIR):
	@echo "Creating $@... \c"
	mkdir -p $@
	@echo "Done"

# see above
$(INVENTORY_DIR):
	@echo "Creating $@... \c"
	mkdir -p $@
	@echo "Done"

# rebuild static assets if the asset folder has changes
$(ASSET_OUT): $(ASSET_IN)
	@echo "Running Webpack... \c"
	npm run-script dev > /dev/null 2>&1
	@echo "Done"

# this will create a single ip inventory with your configured ip
$(REMOTE_INV): $(INVENTORY_DIR) $(MAKEVAR_FILE) 
	@echo "$(REMOTE_IP) 	ansible_user=$(REMOTE_ANSIBLE_USER)" >| $@

# see above, but for a local server ip
$(LOCAL_INV): $(INVENTORY_DIR) $(MAKEVAR_FILE)
	@echo "$(LOCAL_IP) 	ansible_user=$(LOCAL_ANSIBLE_USER)" >| $@

# creates a makevars file, which is needed to fill in secrets
$(MAKEVAR_FILE):
	touch $@

# This creates the sqlite database for development and applies the schema according to current entity mapping
$(SCHEMA_MARK):
	./bin/console doctrine:database:create -q --env=$(ENV)
	./bin/console doctrine:schema:create -q --env=$(ENV)
	touch $@

# With the schema up to date, the fixture can be loaded
# This should only rerun, if the fixture files change
$(FIXTURE_MARK): $(MARK_DIR) $(SCHEMA_MARK) $(MIGRATION_MARK) $(FIXTURES_DIR)/*.php
	./bin/console doctrine:fixture:load -n --env=$(ENV)
	touch $@

# When your entities change, your schema needs to adapt to those changes
# This should only rerun, if your entities change
$(MIGRATION_MARK): $(MARK_DIR) $(SCHEMA_MARK) $(ENTITY_DIR)/*.php
	./bin/console doctrine:migrations:diff -n -q --allow-empty-diff --env=$(ENV)
	./bin/console doctrine:migrations:migrate -n --allow-no-migration --env=$(ENV)
	touch $@


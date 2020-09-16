-include makevars
MAKEVAR_FILE = makevars

# Variable defaults
# Those can be changed with your own makevars file

# Controls for which environment the commands run - never use prod
ENV ?= dev
# Which inventory file will you use - a local.ini or a remote.ini
# You can create your own inventories and use them as option here
INVENTORY ?= local.ini
# IP of your local development server
LOCAL_IP ?= 0.0.0.0
# IP of your remote server - this could be productions or testing
REMOTE_IP ?= 0.0.0.0

# Paths
MARK_DIR = ./.markers
VAR_DIR = ./var
ANSIBLE_DIR = ./infrastructure
INVENTORY_DIR = $(ANSIBLE_DIR)/inventory
DOMAIN_DIR = ./source/Domain
ENTITY_DIR = $(DOMAIN_DIR)/Model
FIXTURES_DIR = $(DOMAIN_DIR)/Fixtures
DEV_STATE_DIR = $(DOMAIN_DIR)/State/Development
PROD_STATE_DIR = $(DOMAIN_DIR)/State/Production
TEST_STATE_DIR = $(DOMAIN_DIR)/State/Test
JS_DEPS = ./node_modules/
PHP_DEPS = ./vendor/
ASSET_OUT = ./public/build

# Files
REMOTE_INV = $(INVENTORY_DIR)/remote.ini
LOCAL_INV = $(INVENTORY_DIR)/local.ini

# Those files signal different states of the sqlite file
SCHEMA_MARK = $(MARK_DIR)/schema
FIXTURE_MARK = $(MARK_DIR)/fixture
MIGRATION_MARK = $(MARK_DIR)/migration

# ------------------------------
# Developer Interface
# ------------------------------

# Thanks to Romain Gautier for his slides from symfony live 2018 providing this ->
.DEFAULT_GOAL := help
help: ## Show this help text
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## General
.PHONY: install
install: $(MARK_DIR) $(DEV_STATE_DIR) $(PROD_STATE_DIR) $(TEST_STATE_DIR) $(JS_DEPS) $(PHP_DEPS) $(FIXTURE_MARK) ## Setup dependencies for local development

.PHONY: run 
run: $(MIGRATION_MARK) $(FIXTURE_MARK) ## Apply migrations and fixtures, build assets and run the application
	npm run-script dev
	symfony serve
	
.PHONY: tests
tests: ## Run all tests
	./bin/phpunit -c ./config/packages/test/phpunit.xml.dist

.PHONY: migrations
migrations: $(MIGRATION_MARK) ## Generate and apply a doctrine migration

.PHONY: fixtures
fixtures: $(FIXTURE_MARK) ## Apply doctrine fixtures

.PHONY: inventories
inventories: $(LOCAL_INV) $(REMOTE_INV) ## Create your ansible inventories according to your makevars

.PHONY: deploy
deploy: $(LOCAL_INV) $(REMOTE_INV) ## Deploy this project with ansible 
	ansible-playbook $(ANSIBLE_DIR)/setup.yaml -i $(INVENTORY_DIR)/$(INVENTORY) -K

.PHONY: clean
clean: ## Remove all temporary files
	@rm -rf $(JS_DEPS) # clear npm dependencies
	@rm -rf $(PHP_DEPS) # clear composer dependencies
	@rm -rf $(DEV_STATE_DIR) # clear all migrations (only for development!)
	@rm -rf $(VAR_DIR) # clear all temporary data
	@rm -rf $(MARK_DIR) # clear the state-tracker files
	@rm -rf $(INVENTORY_DIR) # clear the generated inventories
	@rm -rf $(ASSET_OUT) # clear webpack build
	@echo "Tabula rasa!"

# -------------------------------------------------
# Plumber targets
# -------------------------------------------------

# run composer
$(PHP_DEPS): composer.json
	@composer install &> /dev/null
	@echo "composer install successful"

# run npm
$(JS_DEPS): package.json
	@npm install &> /dev/null
	@echo "npm install successful"

# create the directory needed
$(MARK_DIR):
	@mkdir -p $@

# see above
$(DEV_STATE_DIR):
	@mkdir -p $@

# see above
$(TEST_STATE_DIR):
	@mkdir -p $@

# see above
$(PROD_STATE_DIR):
	@mkdir -p $@

# see above
$(INVENTORY_DIR):
	@mkdir -p $@

# this will create a single ip inventory with your configured ip
$(REMOTE_INV): $(INVENTORY_DIR) $(MAKEVAR_FILE) 
	@echo $(REMOTE_IP) >| $@

# see above, but for a local server ip
$(LOCAL_INV): $(INVENTORY_DIR) $(MAKEVAR_FILE)
	@echo $(LOCAL_IP) >| $@

# creates a makevars file, which is needed to fill in the server ip's
$(MAKEVAR_FILE):
	touch $@

# This creates the sqlite database for development
$(SCHEMA_MARK):
	@./bin/console doctrine:database:create -q --env=$(ENV)
	@./bin/console doctrine:schema:create -q --env=$(ENV)
	@touch $@

# With the schema in place, the fixture can be loaded
# This should only rerun if the fixture files change and therefore also needs a marker
$(FIXTURE_MARK): $(MARK_DIR) $(SCHEMA_MARK) $(MIGRATION_MARK) $(FIXTURES_DIR)/*.php
	@./bin/console doctrine:fixture:load -n --env=$(ENV)
	@touch $@

$(MIGRATION_MARK): $(MARK_DIR) $(SCHEMA_MARK) $(ENTITY_DIR)/*.php
	@./bin/console doctrine:migrations:diff -n -q --allow-empty-diff --env=$(ENV)
	@./bin/console doctrine:migrations:migrate -n --allow-no-migration --env=$(ENV)
	@touch $@



# Variables
ENV = dev # never use prod - NEVER

MARK_DIR = ./.markers
VAR_DIR = ./var
ANSIBLE_DIR = ./infrastructure
INVENTORY_DIR = $(ANSIBLE_DIR)/inventory
FIXTURES_DIR = ./source/Domain/Fixtures
DEV_STATE_DIR = ./source/Domain/State/Development
PROD_STATE_DIR = ./source/Domain/State/Production
TEST_STATE_DIR = ./source/Domain/State/Test

JS_DEPS = ./node_modules/
PHP_DEPS = ./vendor/
DEV_DB_FILE = $(VAR_DIR)/data.db
FIXTURE_MARK = $(MARK_DIR)/fixtures
SCHEMA_MARK = $(MARK_DIR)/schema


# ------------------------------
# Developer Interface
# ------------------------------

# Thanks to Romain Gautier for his slides from symfony live 2018 providing this ->
.DEFAULT_GOAL := help
help: ## Show this help text
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## General
.PHONY: install
install: ALL_DIRS ALL_DEPS $(FIXTURE_MARK) ## Setup the project

.PHONY: test
test: ## Run phpunit
	./bin/phpunit -c ./config/packages/test/phpunit.xml.dist

.PHONY: migration
migration: ## Generate and apply a doctrine migration
	./bin/console doctrine:migrations:diff -n --allow-empty-diff --env=$(ENV)
	./bin/console doctrine:migrations:migrate -n --env=$(ENV)

.PHONY: fixtures
fixtures: $(FIXTURE_MARK) ## Apply fixtures changes

.PHONY: deploy-local
deploy-local: ## Run ansible for your local server
	ansible-playbook $(ANSIBLE_DIR)/setup.yaml -i $(INVENTORY_DIR)/local.ini

.PHONY: deploy-remote
deploy-remote: ## Run ansible for the remote server
	ansible-playbook $(ANSIBLE_DIR)/setup.yaml -i $(INVENTORY_DIR)/remote.ini

.PHONY: clear
clear: ## Delete all temporary files
	@rm -rf $(JS_DEPS) # delete npm dependencies
	@rm -rf $(PHP_DEPS) # delete composer dependencies
	@rm -rf $(DEV_STATE_DIR) # clear all migrations only for development!
	@rm -rf $(VAR_DIR) # clear all temporary data
	@rm -rf $(MARK_DIR) # created with this makefile to track more information

# -------------------------------------------------
# Helper targets
# -------------------------------------------------

# run composer
$(PHP_DEPS): composer.json
	composer install

# run npm
$(JS_DEPS): package.json
	npm install

# create the directory needed
$(MARK_DIR):
	mkdir -p $@

# see above
$(DEV_STATE_DIR):
	mkdir -p $@

# see above
$(TEST_STATE_DIR):
	mkdir -p $@

# see above
$(PROD_STATE_DIR):
	mkdir -p $@

# This creates the sqlite database for development
$(DEV_DB_FILE):
	./bin/console doctrine:database:create --env=$(ENV)

# With the sqlite file in place, the schema will be created
# This should only run once at install and needs the marker file to do so
$(SCHEMA_MARK): $(DEV_DB_FILE)
	./bin/console doctrine:schema:create --env=$(ENV)
	touch $@

# With the schema in place, the fixture can be loaded
# This should only rerun if the fixture files change and therefore also needs a marker
$(FIXTURE_MARK): $(MARK_DIR) $(SCHEMA_MARK) $(FIXTURES_DIR)/*.php
	./bin/console doctrine:fixture:load -n --env=$(ENV)
	touch $@

# all dependencies in one target to save space within the developer interface definition above
ALL_DEPS: $(MARK_DIR) $(JS_DEPS) $(PHP_DEPS)

# all directories in one target to save space within the developer interface definition above
ALL_DIRS: $(MARK_DIR) $(DEV_STATE_DIR) $(PROD_STATE_DIR) $(TEST_STATE_DIR)


ENV = dev
DEV_STATE_DIR = ./source/Domain/State/Development
PROD_STATE_DIR = ./source/Domain/State/Production
TEST_STATE_DIR = ./source/Domain/State/Test
DEV_DB_FILE = ./var/data.db

.DEFAULT_GOAL := help
help: ## Show this help text
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## General
.PHONY: clear
clear: ## Deletes all dependencies and temporary files
	@rm -rf node_modules/ # delete npm dependencies
	@rm -rf vendor/ # delete composer dependencies
	@rm -rf $(DEV_STATE_DIR) # clear all migrations only for development!
	@rm -rf var/ # clear all temporary data
	@rm -f ./config/packages/doctrine.yaml # created by recipe, but renamed to orm.yaml
	@rm -f ./config/packages/doctrine_migrations.yaml # created by recipe, but renamed to migrations.yaml
	@rm -f ./config/packages/prod/doctrine.yaml # created by recipe, but renamed to orm.yaml
	@rm -rf ./src # created by recipe, but renamed to source
	@rm -rf ./migrations  # created by recipe, but renamed to State/$env for every environment

.PHONY: install
install: $(DEV_STATE_DIR) $(TEST_STATE_DIR) $(PROD_STATE_DIR) vendor/ node_modules/ $(DEV_DB_FILE) ## Setup the project
	./bin/console doctrine:schema:drop --force --env=$(ENV)
	./bin/console doctrine:schema:create --env=$(ENV)

.PHONY: migration
migration: ## Generates and applies a doctrine migration
	./bin/console doctrine:migrations:diff -n --allow-empty-diff --env=$(ENV)
	./bin/console doctrine:migrations:migrate -n --env=$(ENV)

# Helper targets
# Not relevant for Operation

vendor/: composer.json
	composer install

node_modules/: package.json
	npm install

$(DEV_STATE_DIR):
	mkdir $@

$(TEST_STATE_DIR):
	mkdir $@

$(PROD_STATE_DIR):
	mkdir $@

$(DEV_DB_FILE):
	./bin/console doctrine:database:create --env=$(ENV)

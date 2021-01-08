-include makevars
# reference to makevars within the targets
MAKEVAR_FILE = makevars

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
TOOLS_DIR = ./.tools
TOOL_CONFIG_DIR = $(TOOLS_DIR)/config
SOURCE_DIR = ./source
TEST_DIR = ./tests
DOMAIN_DIR = $(SOURCE_DIR)/Domain
ENTITY_DIR = $(DOMAIN_DIR)/Model
STATE_DIR = $(DOMAIN_DIR)/State
FIXTURES_DIR = $(STATE_DIR)/Fixtures
MIG_DIR = $(STATE_DIR)/Migrations
DEV_STATE_DIR = $(MIG_DIR)/Development
ASSET_IN = $(SOURCE_DIR)/View/Assets
# Infrastructure as Code
VAR_DIR = ./var
JS_DEPS = ./node_modules
PHP_DEPS = ./vendor

ALL_DIRS = $(MARK_DIR) $(DEV_STATE_DIR) $(VAR_DIR)
TEMPORARY = $(JS_DEPS) $(PHP_DEPS) $(DEV_STATE_DIR) $(VAR_DIR) $(MARK_DIR) $(ASSET_OUT)
# --------------------------------------------------------------
# Developer Interface
# --------------------------------------------------------------

# Don't print the commands, only their output
.SILENT: 
# Those are all commands of the developer interface
# Everything under phony will run even if a file with that name exists
.PHONY: help debug install run tests clean assets migrations fixtures deploy codestyle analysis

# The target used, if you call just make without any argument
.DEFAULT_GOAL := help

# If something went wrong, delete the broken parts
.DELETE_ON_ERROR:


# Import after all vars set is important to have them in the recipes
-include .tools/recipes/symfony.makerecipe
-include .tools/recipes/quality.makerecipe
-include .tools/recipes/deployment.makerecipe


# Thanks to Romain Gautier for his slides from symfony live 2018 providing this ->
##--------Developer Interface----
help: ## Print this help text
	$(foreach FILE, $(MAKEFILE_LIST), grep -E '(^[a-zA-Z_]+:.*?##.*$$)|(^##)' $(FILE) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/';)

files: ## echo all files imported
	echo $(MAKEFILE_LIST)

debug: ## Print all information for debugging the makefile
	echo "Following is marked for the clean target: $(TEMPORARY)"
	echo "Directories made by make: $(ALL_DIRS)"
	echo "Hooks detected: $(HOOK_REQ_FILES)"

##--------General----------------
install: $(ALL_DIRS) $(JS_DEPS) $(PHP_DEPS) $(FIXTURE_MARK) ## Run all tasks necessary to run the application

run: $(MIGRATION_MARK) $(FIXTURE_MARK) $(ASSET_OUT) $(HOSTS_FILE) ## Apply all Symfony targets and run the application
	symfony serve

clean: ## Remove all temporary files
	@echo "Start cleanup..."
	rm -rf $(TEMPORARY)
	@echo "This removed the following:"
	@echo $(sort $(TEMPORARY))

# run composer
$(PHP_DEPS): composer.json
	echo "Running composer... \c"
	composer install -q
	echo "Done"

# run npm
$(JS_DEPS): package.json
	echo "Running npm... \c"
	npm install --no-audit --no-fund --no-update-notifier --no-progress
	echo "Done"

# create all the directories needed
$(ALL_DIRS):
	echo "Creating $@... \c"
	mkdir -p $@
	echo "Done"


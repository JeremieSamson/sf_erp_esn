DOCKER_COMPOSE?=docker-compose
RUN=$(DOCKER_COMPOSE) run --rm php
EXEC?=$(DOCKER_COMPOSE) exec app
COMPOSER=$(EXEC) composer
CONSOLE=$(EXEC) bin/console
PHPCSFIXER?=$(EXEC) php -d memory_limit=1024m vendor/bin/php-cs-fixer
BEHAT=$(EXEC) vendor/bin/behat
BEHAT_ARGS?=-vvv
PHPUNIT=$(EXEC) bin/phpunit
PHPUNIT_ARGS?=-v
DOCKER_FILES=$(shell find ./docker/php/ -type f -name '*')

.DEFAULT_GOAL := help
.PHONY: help start stop reset db db-diff db-diff-dump db-migrate db-rollback db-load watch clear clean test tu tf tj lint ls ly lt
.PHONY: lj build up perm deps cc phpcs phpcsfix tty tfp tfp-rabbitmq tfp-db test-behat test-phpunit-functional
.PHONY: wait-for-db security-check rm-docker-dev.lock

help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

##
## Project setup
##---------------------------------------------------------------------------

start: build up .env db assets                                                                   ## Install and start the project

stop:                                                                                                                 ## Remove docker containers
	$(DOCKER_COMPOSE) kill
	$(DOCKER_COMPOSE) rm -v --force

reset: stop rm-docker-dev.lock start

clear: rm-docker-dev.lock                                                                                             ## Remove all the cache, the logs, the sessions and the built assets
	-$(EXEC) rm -rf var/cache/*
	-$(EXEC) rm -rf var/sessions/*
	-$(EXEC) rm -rf supervisord.log supervisord.pid npm-debug.log .tmp
	-$(CONSOLE) redis:flushall -n
	rm -rf var/logs/*
	rm -rf web/built
	rm var/.php_cs.cache

clean: clear                                                                                           ## Clear and remove dependencies
	rm -rf vendor node_modules

cc:                                                                                                    ## Clear the cache in dev env
	$(CONSOLE) cache:clear --no-warmup
	$(CONSOLE) cache:warmup

tty:                                                                                                   ## Run app container in interactive mode
	$(RUN) /bin/bash

##
## Database
##---------------------------------------------------------------------------

wait-for-db:
	$(EXEC) php -r "set_time_limit(60);for(;;){if(@fsockopen('mysql',3306)){break;}echo \"Waiting for MySQL\n\";sleep(1);}"

db: vendor wait-for-db                                                                                 ## Reset the database and load fixtures
	$(CONSOLE) doctrine:database:drop --force --if-exists
	$(CONSOLE) doctrine:database:create --if-not-exists
	$(CONSOLE) doctrine:migrations:migrate -n
	$(CONSOLE) doctrine:fixtures:load -n

db-diff: vendor wait-for-db                                                                            ## Generate a migration by comparing your current database to your mapping information
	$(CONSOLE) doctrine:migration:diff  

db-diff-dump: vendor wait-for-db                                                                       ## Generate a migration by comparing your current database to your mapping information and display it in console
	$(CONSOLE) doctrine:schema:update --dump-sql

db-migrate: vendor wait-for-db                                                                         ## Migrate database schema to the latest available version
	$(CONSOLE) doctrine:migration:migrate -n

db-rollback: vendor wait-for-db                                                                        ## Rollback the latest executed migration
	$(CONSOLE) doctrine:migration:migrate prev -n

db-load: vendor wait-for-db                                                                            ## Reset the database fixtures
	$(CONSOLE) doctrine:fixtures:load -n

db-validate: vendor wait-for-db                                                                        ## Check the ORM mapping
	$(CONSOLE) doctrine:schema:validate


##
## Assets
##---------------------------------------------------------------------------

assets:                                                                                                ## Build the development version of the assets
	$(CONSOLE) assets:install


##
## Tests
##---------------------------------------------------------------------------

test: tu tf tj                                                                                         ## Run the PHP and the Javascript tests

test-behat:                                                                                            ## Run behat tests
	$(BEHAT) $(BEHAT_ARGS)

test-phpunit:                                                                                          ## Run phpunit tests
	$(PHPUNIT) $(PHPUNIT_ARGS)

test-debug:                                                                                            ## Run tests with debug group/tags
	$(PHPUNIT) -vvv --group debug

test-phpunit-functional:                                                                               ## Run phpunit fonctional tests
	$(PHPUNIT) --group functional

tu: vendor app/config/assets_version.yml                                                               ## Run the PHP unit tests
	$(PHPUNIT) --exclude-group functional

tf: tfp test-behat test-phpunit-functional                                                             ## Run the PHP functional tests

tfp: assets-amp assets-prod assets-apps vendor perm tfp-rabbitmq tfp-db                                ## Prepare the PHP functional tests

tfp-db: wait-for-db                                                                                    ## Init databases for tests
	$(EXEC) rm -rf /tmp/data.db app/data/dumped_referents_users || true
	$(CONSOLE) doctrine:database:drop --force --if-exists --env=test
	$(CONSOLE) doctrine:database:create --env=test
	$(CONSOLE) doctrine:database:import --env=test -n -- dump/dump-2018.sql
	$(CONSOLE) doctrine:migration:migrate -n --env=test
	$(CONSOLE) doctrine:schema:validate --env=test
	$(CONSOLE) doctrine:fixtures:load --env=test -n

tj: node_modules                                                                                       ## Run the Javascript tests
	$(EXEC) yarn test

lint: ls ly lt lj phpcs                                                                                ## Run lint on Twig, YAML, PHP and Javascript files

ls: ly lt                                                                                              ## Lint Symfony (Twig and YAML) files

ly:
	$(CONSOLE) lint:yaml app/config --parse-tags

lt:
	$(CONSOLE) lint:twig templates

lj: node_modules                                                                                       ## Lint the Javascript to follow the convention
	$(EXEC) yarn lint

ljfix: node_modules                                                                                    ## Lint and try to fix the Javascript to follow the convention
	$(EXEC) yarn lint -- --fix

phpcs: vendor                                                                                          ## Lint PHP code
	$(PHPCSFIXER) fix --diff --dry-run --no-interaction -v

phpcsfix: vendor                                                                                       ## Lint and fix PHP code to follow the convention
	$(PHPCSFIXER) fix

security-check: vendor                                                                                 ## Check for vulnerable dependencies
	$(EXEC) vendor/bin/security-checker security:check


##
## Dependencies
##---------------------------------------------------------------------------

deps: vendor                                                                                           ## Install the project PHP and JS dependencies

##


# Internal rules

build: docker-dev.lock

docker-dev.lock: $(DOCKER_FILES)
	$(DOCKER_COMPOSE) pull --ignore-pull-failures
	$(DOCKER_COMPOSE) build --force-rm --pull
	touch docker-dev.lock

rm-docker-dev.lock:
	rm -f docker-dev.lock

up:
	$(DOCKER_COMPOSE) up -d --remove-orphans

# Rules from files

vendor: composer.lock
	$(COMPOSER) install -n

composer.lock: composer.json
	@echo composer.lock is not up to date.

.env: .env.dist vendor
	$(EXEC) composer -n run-script post-install-cmd

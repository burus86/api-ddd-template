## see:
## 		https://www.gnu.org/software/make/manual/html_node/index.html
## 		https://www.gnu.org/prep/standards/html_node/Makefile-Conventions.html
## 		https://docs.php.earth/interop/make/

# variables
.DEFAULT_GOAL := help
.PHONY : help help-symfony start stop install update require bash logs debug-router phpdoc test
CONTAINERS = api-ddd-template_php api-ddd-template_db
CONTAINER_NAME = api-ddd-template_php
CONTAINER_OPTIONS = -it
RUN = docker exec $(CONTAINER_OPTIONS) $(CONTAINER_NAME)
#PHPUNIT_FILE = phpunit.xml.dist
PHPMD_FILE = phpmd.xml
PHPSTAN_FILE = phpstan.neon
CHURN_FILE = churn.yml
COLOR_RESET = \033[0m
COLOR_INFO = \033[32m
COLOR_COMMENT = \033[33m


## Help
help:
	@printf "${COLOR_COMMENT}Usage:${COLOR_RESET}\n"
	@printf " make [target]\n\n"
	@printf "${COLOR_COMMENT}Available targets:${COLOR_RESET}\n"
	@awk '/^[a-zA-Z\-\_0-9\.@]+:/ { \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf " ${COLOR_INFO}%-16s${COLOR_RESET} %s\n", helpCommand, helpMessage; \
		} \
	} \
	{ lastLine = $$0 }' $(MAKEFILE_LIST)

## Symfony console available commands
help-symfony: start bin/console
	@echo "Symfony console available commands"
	@echo "---------------------------"
	@echo
	$(RUN) php bin/console list
	@echo

## Start docker containers
start:
	@echo "Starting docker containers"
	@echo "---------------------------"
	@echo
	docker-compose -f docker/docker-compose.yml up -d --build --remove-orphans
	@echo

## Stop docker containers
stop:
	@echo "Stopping docker containers"
	@echo "---------------------------"
	@echo
	docker stop $(CONTAINERS)
	@echo

## Install PHP dependencies
install: start composer.json $(wildcard composer.lock)
	@echo "Installing PHP dependencies"
	@echo "---------------------------"
	@echo
	$(RUN) composer install
	@echo

## Update PHP dependencies
update: start composer.json $(wildcard composer.lock)
	@echo "Updating PHP dependencies"
	@echo "---------------------------"
	@echo
	$(RUN) composer update
	@echo

## Require new PHP dependencies. Example: make require PACKAGE=phpstan/phpstan ENV=--dev
require: start composer.json
	@echo "Require new PHP dependencies:"
	@echo "---------------------------"
	@echo
	$(RUN) composer require $(ENV) $(PACKAGE)
	@echo

## Access docker container bash
bash: start
	@echo "Access docker container bash"
	@echo "---------------------------"
	@echo
	$(RUN) bash

## Show docker container logs
logs: start
	@echo "Show docker container logs"
	@echo "---------------------------"
	@echo
	docker logs -f -n20 $(CONTAINER_NAME)

## Show all symfony routes or an individual route. Example: make debug-router ROUTE=first_author_vertical
debug-router: start bin/console
	@echo "Show all symfony routes or an individual route"
	@echo "---------------------------"
	@echo
	$(RUN) php bin/console debug:router $(ROUTE)
	@echo

## Generate full project documentation
phpdoc: start phpDocumentor.phar
	@echo "Generate full project documentation"
	@echo "---------------------------"
	@echo
	$(RUN) php phpDocumentor.phar -d src -t public/docs
	@echo

## Run all tests (PHP Unit, PHP_CodeSniffer, PHPStan, PHP Mess Detector, Deptrac, ...)
test: start vendor test-phpunit test-phpcs test-phpstan test-phpmd test-phpmnd test-phpcpd test-churn test-phpdd test-deptrac test-twigcs

## Run PHP Unit Tests
test-phpunit: start bin/phpunit
	@echo "Run PHP Unit Tests"
	@echo "---------------------------"
	@echo
	$(RUN) bin/phpunit
	@echo

## Run PHP_CodeSniffer and detect violations of a defined coding standard
test-phpcs: start bin/phpcs
	@echo "Run PHP_CodeSniffer: phpcs"
	@echo "---------------------------"
	@echo
	$(RUN) bin/phpcs src/ tests/
	@echo

## Run PHP_CodeSniffer and automatically correct coding standard violations
test-phpcbf: start bin/phpcbf
	@echo "Run PHP_CodeSniffer: phpcbf"
	@echo "---------------------------"
	@echo
	$(RUN) bin/phpcbf src/ tests/
	@echo

## Run PHPStan
test-phpstan: start bin/phpstan
	@echo "Run PHPStan"
	@echo "---------------------------"
	@echo
	$(RUN) bin/phpstan analyse -c $(PHPSTAN_FILE)
	@echo

## Run PHP Mess Detector
test-phpmd: start bin/phpmd
	@echo "Run PHP Mess Detector"
	@echo "---------------------------"
	@echo
	$(RUN) bin/phpmd src/ text $(PHPMD_FILE)
	@echo

## Run PHP Magic Number Detector
test-phpmnd: start bin/phpmnd
	@echo "Run PHP Magic Number Detector"
	@echo "---------------------------"
	@echo
	$(RUN) bin/phpmnd src tests --progress --extensions=all
	@echo

## Run PHP Copy Paste Detector
test-phpcpd: start bin/phpcpd
	@echo "Run PHP Copy Paste Detector"
	@echo "---------------------------"
	@echo
	$(RUN) bin/phpcpd ./ --exclude=var --exclude=vendor --fuzzy --min-lines=5
	@echo

## Run Churn-php
test-churn: start bin/churn
	@echo "Run Churn-php"
	@echo "---------------------------"
	@echo
	$(RUN) bin/churn run --configuration=$(CHURN_FILE)
	@echo

## Run PhpDeprecationDetector
test-phpdd: start bin/phpdd
	@echo "Run PhpDeprecationDetector"
	@echo "---------------------------"
	@echo
	$(RUN) bin/phpdd src/ tests/
	@echo

## Run Deptrac
test-deptrac: start bin/deptrac
	@echo "Run Deptrac"
	@echo "---------------------------"
	@echo
	$(RUN) bin/deptrac analyse
	@echo

## Run Twigcs
test-twigcs: start bin/twigcs
	@echo "Run twigcs"
	@echo "---------------------------"
	@echo
	$(RUN) bin/twigcs templates/
	@echo

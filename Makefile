message = @echo "\n----------------------------------------\n$(1)\n----------------------------------------\n"

ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))

root = $(dir $(realpath $(lastword $(MAKEFILE_LIST))))
compose = docker-compose

app = $(compose) run --user www -T workspace
artisan = $(app) php artisan

pull:
	$(compose) pull

up:
	$(compose) up -d --remove-orphans

down:
	$(compose) down

restart: down up
	$(call message,"Restart completed")

update: down
	$(compose) pull
	$(MAKE) up
	$(call message,"Update completed")

app-install:
	$(app) composer install
	$(app) php artisan migrate

app-key-generate:
	$(app) php artisan key:generate

console-in:
	$(compose) run --user www workspace bash

migrate:
	$(app) php artisan migrate --no-interaction

test:
	$(app) vendor/phpunit/phpunit/phpunit

ps:
	$(compose) ps

build:
	$(compose) build --no-cache app workspace

db:
	$(compose) exec postgres bash

log:
	$(compose) logs

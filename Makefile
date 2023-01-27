message = @echo "\n----------------------------------------\n$(1)\n----------------------------------------\n"

ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))

root = $(dir $(realpath $(lastword $(MAKEFILE_LIST))))
compose = docker-compose

app = $(compose) exec -T app

up:
	$(compose) up -d --remove-orphans

stop:
	$(compose) stop

down:
	$(compose) down

app-install:
	$(compose) run workspace composer install

console:
	$(compose) run workspace bash

ps:
	$(compose) ps

log:
	$(compose) logs

restart: down up

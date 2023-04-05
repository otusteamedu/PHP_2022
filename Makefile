$(shell cp -n .env.dist .env && mkdir -p ./app/var/log)

include ./.env
export $(shell sed 's/=.*//' ./.env)

filter ?= "--help";

init:	## Install and run service.
	@make up
	docker-compose run --rm php-cli composer install
	docker-compose run --rm php-cli es-check bin/database
	@make dump-restore

up:	## Start service. Rebuild if necessary.
	docker-compose up --build -d
	docker-compose run --rm php-cli composer install

down:	## Down service.
	docker-compose down --remove-orphans

down-clear:	## Down service and remove volumes.
	docker-compose down --remove-orphans -v
	rm -rf ./app/var/*

analyze:	## Run a static code analyzers.
	docker-compose run --rm php-cli composer analyze

search:	## Run console command bookstore:book:search.
	docker-compose run --rm php-cli bin/console bookstore:book:search ${filter}

dump-restore:	## Restore ES dump file.
	docker-compose run --rm php-cli es-check curl -H "Content-Type: application/x-ndjson" -X POST "${ES_URL}/_bulk?pretty" --data-binary "@/dump.json"

.PHONY: help

help:	## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033\n\nTargets:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-12s\033[0m %s\n", $$1, $$2 }' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

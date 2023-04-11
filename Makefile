$(shell cp -n .env.dist .env && mkdir -p ./app/var/log ./app/var/run)

include ./.env
export $(shell sed 's/=.*//' ./.env)

init:	## Install and run service.
	@make up
	docker-compose run --rm php-fpm cli install

up:	## Start service. Rebuild if necessary.
	docker-compose up --build -d

down:	## Down service.
	docker-compose down --remove-orphans

down-clear:	## Down service and remove volumes.
	docker-compose down --remove-orphans -v
	rm -rf ./app/var/*

analyze:	## Run a static code analyzers.
	docker-compose run --rm php-cli composer analyze

test:	## Run phpunit tests.
	docker-compose run --rm php-cli composer test

.PHONY: help

help:	## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033\n\nTargets:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-12s\033[0m %s\n", $$1, $$2 }' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

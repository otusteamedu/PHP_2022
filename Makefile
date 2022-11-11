DOCKER_COMPOSE = docker compose

init: down up composer-install

up:
	${DOCKER_COMPOSE} up -d

down:
	${DOCKER_COMPOSE} down

build:
	${DOCKER_COMPOSE} build

restart: down up

composer-install:
	${DOCKER_COMPOSE} run --rm composer composer install

composer-update:
	${DOCKER_COMPOSE} run --rm composer composer install

app-test:
	${DOCKER_COMPOSE} run --rm composer composer test

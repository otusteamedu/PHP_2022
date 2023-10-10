DOCKER_COMPOSE = docker compose

init: up composer-install

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
	${DOCKER_COMPOSE} run --rm composer composer update

start-server:
	${DOCKER_COMPOSE} run --rm php-cli php bin/app.php server

start-client:
	${DOCKER_COMPOSE} run --rm php-cli php bin/app.php client

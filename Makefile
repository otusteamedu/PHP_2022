DOCKER_COMPOSE = docker compose

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

cs-check:
	${DOCKER_COMPOSE} run --rm composer composer cs-check

cs-fix:
	${DOCKER_COMPOSE} run --rm composer composer cs-fix

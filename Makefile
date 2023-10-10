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

deptrac-analyze:
	${DOCKER_COMPOSE} run --rm php-cli php vendor/bin/deptrac --cache-file=./var/.deptrac.cache

psalm-analyze:
	${DOCKER_COMPOSE} run --rm php-cli php vendor/bin/psalm

cs-check:
	${DOCKER_COMPOSE} run --rm php-cli php vendor/bin/phpcs

cs-fix:
	${DOCKER_COMPOSE} run --rm php-cli php vendor/bin/phpcbf

start-server:
	${DOCKER_COMPOSE} run --rm php-cli php bin/app.php server

start-client:
	${DOCKER_COMPOSE} run --rm php-cli php bin/app.php client

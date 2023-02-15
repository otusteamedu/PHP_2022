DOCKER_COMPOSE = docker compose

clean-up:
	${DOCKER_COMPOSE} up -d --remove-orphans

up:
	${DOCKER_COMPOSE} up -d

down:
	${DOCKER_COMPOSE} down

restart: down up
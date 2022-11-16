init: docker-down-clear docker-pull docker-build
up: docker-up
down: docker-down
restart: down up

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

bash:
	docker exec -it call_log_app bash

docker-build:
	docker-compose build --pull

docker-pull:
	docker-compose pull

docker-down-clear:
	docker-compose down -v --remove-orphans
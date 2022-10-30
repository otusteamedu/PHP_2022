docker-up:
	docker-compose up -d --build

docker-down:
	docker-compose down --remove-orphans

docker-restart: docker-down docker-up

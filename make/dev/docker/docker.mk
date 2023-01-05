docker-up:
	docker-compose up --build -d

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-init: docker-down-clear docker-up

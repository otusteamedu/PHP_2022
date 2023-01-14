up:
	docker-compose up -d
down:
	docker-compose down
rebuild:
	docker-compose up --build -d
restart: down up



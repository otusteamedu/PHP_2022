build:
	docker-compose -f docker-compose.yml
rebuild:
	docker-compose -f docker-compose.yml build --no-cache
start:
	docker-compose -f docker-compose.yml up -d
stop:
	docker-compose -f docker-compose.yml down
restart:
	docker-compose -f docker-compose.yml down
	docker-compose -f docker-compose.yml up -d

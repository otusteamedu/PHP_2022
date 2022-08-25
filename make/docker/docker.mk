docker-build:
	docker-compose build

docker-up:
	docker-compose up -d

docker-down-clear:
	docker-compose down -v --remove-orphans

server-app:
	docker-compose run --rm server php app.php

client-app:
	docker-compose run --rm client php app.php

docker-init: docker-down-clear docker-build docker-up

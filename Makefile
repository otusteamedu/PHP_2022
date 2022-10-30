restart-all:
	docker-compose stop && docker-compose up -d

build-all:
	docker-compose up -d --build

bash-php-fpm:
	docker-compose exec php-fpm bash
pg-dump:
	docker-compose exec -u ${POSTGRES_USER} postgres pg_dump -S ${POSTGRES_USER} -Fc ${POSTGRES_DB} > app/var/dump/${POSTGRES_DB}.sql

pg-isready:
	docker-compose run --rm php-cli pg_isready

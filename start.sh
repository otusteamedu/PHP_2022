#!/bin/bash
docker-compose down -v
docker-compose build --no-cache
docker-compose up -d
#docker exec -it app1 composer install
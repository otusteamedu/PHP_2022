# PHP_2022

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## First steps
add to file /etc/hosts

```shell
127.0.0.1  mysite.local
```

```shell
# first up
docker-compose up -d --build --remove-orphans  # first run and build docker images
docker-compose run workspace composer install # install dependencies
# or 
make build-app
make app-install 
```

## For working
```shell
docker-compose up -d --remove-orphans
# or 
make up
```
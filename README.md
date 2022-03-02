# PHP_2022

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

-------

# How it uses: 

### Get composer libs

`docker-compose run workspace  bash`

in container execute this:

`composer install`

-------

### Start server:

`docker-compose run socket-server bash`

in container execute this:

`php server.php`

-------

### Start client

> Start only after server container

`docker-compose run socket-client bash php client.php`

in container execute this:

`php client.php`

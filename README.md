# PHP_2022

## Homework #7

### Instructions chat unix-sockets 

#### run docker-compose

```
docker-compose build
docker-compose up -d
```
#### run server

```
docker exec -ti php-server php /data/hw7.local/public/index.php server
```

#### run client

```
docker exec -ti php-client php /data/hw7.local/public/index.php client
```
# PHP_2022

## Instructions

### Checkout GIT project
```
git clone https://github.com/otusteamedu/PHP_2022.git
git checkout KDmitrienko/hw6
```

### Run chat via unix-sockets

```
cd code && composer install && cd ..
docker-compose up -d

1. in one terminal start the server:
docker exec -ti app-server php app.php server

2. in another terminal start the client
docker exec -ti app-client php app.php client
```

# Websocket chat



## Requirements

- installed docker

## Insatallation

- Start containers
```bash
docker-compose up -d --build --remove-orphans
```
- Go inside the container 
```bash
docker-compose run socket-chat-server bash
 ```
- Install composer libs in container
```bash 
composer install
 ```
- Exit container
```bash
exit
 ```

## Usage
- At first (it's important!) run container with server side 
```bash
docker-compose run socket-chat-server bash
 ```
- Run script in container with server side
```bash
php server.php
 ```
 
- Run container with client
```bash
docker-compose run socket-chat-client bash
```
- Run script in client container
```bash
php client.php
```

- Follow instructions in client container
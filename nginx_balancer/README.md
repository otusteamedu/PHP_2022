# Nginx balancer

Пакет позволяет осуществлять транслитерацию слов с русского на английский язык.

## Requirements

- php7.4

## First step

copy .env.example to .env
add to /etc/hosts ```127.0.0.1 mysite.local```
## Project initializing

```bash
$ docker-composer up -d --build
```

## Usage

http://mysite.local/braces
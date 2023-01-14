ARG PHP_VERSION=8.1

FROM php:${PHP_VERSION}-cli-alpine

COPY ./php-cli/conf.d /usr/local/etc/php/conf.d

RUN docker-php-ext-install sockets

WORKDIR /app
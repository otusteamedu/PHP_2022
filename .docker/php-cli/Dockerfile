ARG PHP_VERSION=8.1

FROM php:${PHP_VERSION}-cli-alpine

RUN apk update && \
    apk add libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql pgsql

COPY ./php-cli/conf.d /usr/local/etc/php/conf.d

WORKDIR /app
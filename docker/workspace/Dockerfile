ARG PHP_VERSION
FROM php:${PHP_VERSION}-fpm-alpine

ARG WORKDIR
WORKDIR ${WORKDIR}

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
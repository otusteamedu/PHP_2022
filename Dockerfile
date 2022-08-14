FROM php:8.1.5-fpm-alpine

ENV COMPOSER_MEMORY_LIMIT='-1'

RUN apk add --no-cache -- \
    bash

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
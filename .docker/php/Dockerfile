FROM php:8.0-fpm-alpine

RUN apk add --no-cache \
    bash \
    libzip \
    libzip-dev \
    autoconf \
    bind-tools \
    gcc libc-dev make \
    sudo && \

    apk add  --no-cache --virtual .phpize-deps && \

    docker-php-ext-install zip pdo pdo_mysql

RUN mkdir /var/run/php



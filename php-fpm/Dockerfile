FROM php:8.1-fpm-alpine

RUN apk add --no-cache \
    libzip \
    libzip-dev \
    autoconf \
    bind-tools \
    gcc libc-dev make \
    sudo \
    && pecl install memcache \
    && docker-php-ext-enable memcache \
    && docker-php-ext-install zip pdo pdo_mysql

WORKDIR /data

FROM php:8.1-fpm-alpine

RUN apk add --no-cache \
    libzip \
    libzip-dev \
    autoconf \
    bind-tools \
    gcc libc-dev make \
    sudo \
    libmemcached-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install zip pdo pdo_mysql

COPY php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

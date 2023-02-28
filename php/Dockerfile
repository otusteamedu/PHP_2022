FROM php:8.0-cli

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libonig-dev \
        libzip-dev \
        libmcrypt-dev \
        && docker-php-ext-install sockets

COPY php/php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data
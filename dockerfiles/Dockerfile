FROM php:8.1.0-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y --no-install-recommends git \
 libpq-dev \
 & pecl install -o -f redis

COPY . .
COPY ./dockerfiles/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini
FROM php:8.0-fpm

RUN apt-get update && apt-get install -y git
RUN pecl install xdebug-3.0.0 && docker-php-ext-enable xdebug \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \

RUN apt-get update && apt-get install -y libz-dev libmemcached-dev && \
    pecl install memcached && \
    docker-php-ext-enable memcached

WORKDIR /var/www

FROM php:8.0-fpm

RUN pecl install xdebug-3.0.0 && docker-php-ext-enable xdebug && docker-php-ext-install sockets

WORKDIR /var/www

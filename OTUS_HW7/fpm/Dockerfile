FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
	&& docker-php-ext-install sockets \
    && docker-php-ext-enable sockets

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

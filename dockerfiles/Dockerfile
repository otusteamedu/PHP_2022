FROM php:8.1.0-cli

RUN apt-get update && apt-get install -y \
     libpq-dev \
     zlib1g-dev \
     && docker-php-ext-install sockets

COPY ./dockerfiles/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini


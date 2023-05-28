FROM php:8.1.19-zts-alpine3.18        

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install sockets

WORKDIR /project
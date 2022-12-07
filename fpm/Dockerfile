FROM php:8.1-fpm

RUN docker-php-ext-install sockets

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]

FROM php:7.4-fpm

RUN docker-php-ext-install sockets

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
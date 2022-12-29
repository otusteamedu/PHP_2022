FROM php:8.1-fpm

RUN apt-get update && docker-php-ext-install pdo_mysql
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
WORKDIR /data

VOLUME /data

CMD ["php-fpm"]

FROM php:8.1-fpm

WORKDIR /data

VOLUME /data

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

CMD ["php-fpm"]

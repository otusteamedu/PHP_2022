FROM php:8.1-fpm-alpine

RUN docker-php-ext-enable opcache

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]

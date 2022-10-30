FROM php:7.4-fpm-alpine3.16


RUN apk update && apk add \
        libmemcached-dev zlib-dev \
        autoconf make gcc g++ \
        postgresql-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pgsql pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /www/application.local

CMD ["php-fpm"]

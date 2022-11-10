ARG PHP_VERSION=8.1

FROM php:${PHP_VERSION}-fpm-alpine

ENV XDEBUG_VERSION 3.1.5

RUN apk update && apk add --no-cache postgresql-dev fcgi git \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && git clone --branch $XDEBUG_VERSION --depth 1 https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug \
    && docker-php-ext-configure xdebug --enable-xdebug-dev \
    && docker-php-ext-install pdo_pgsql xdebug \
    && apk del git

RUN apk --no-cache add autoconf g++ make \
    && pecl install -o -f redis \
    && docker-php-ext-enable redis

RUN apk --no-cache add zlib-dev libmemcached-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached

COPY ./php-fpm/conf.d /usr/local/etc/php/conf.d

WORKDIR /app
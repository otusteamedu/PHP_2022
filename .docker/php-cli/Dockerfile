ARG PHP_VERSION=8.1

FROM php:${PHP_VERSION}-cli-alpine

RUN apk add --no-cache pcre-dev $PHPIZE_DEPS \
    && pecl install redis

RUN apk add --no-cache autoconf g++ make libmemcached-dev zlib-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached

COPY ./php-cli/conf.d /usr/local/etc/php/conf.d

WORKDIR /app
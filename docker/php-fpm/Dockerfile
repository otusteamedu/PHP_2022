FROM php:8.1-fpm-alpine

RUN apk add --no-cache \
    libzip-dev \
    autoconf \
    bind-tools \
    gcc libc-dev make \
    sudo \
    libmemcached-dev \
    oniguruma-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install zip pdo pdo_mysql mbstring

COPY docker/php-fpm/php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /app

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

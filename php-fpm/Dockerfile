
FROM php:8.1-fpm-alpine
RUN apk add --update linux-headers
RUN apk add --no-cache \
    libzip \
    libzip-dev \
    autoconf \
    bind-tools \
    gcc libc-dev make \
    sudo \
    && pecl install xdebug \
    && docker-php-ext-install zip pdo pdo_mysql \
    && docker-php-ext-enable xdebug

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./conf.d /usr/local/etc/php/conf.d

WORKDIR /app
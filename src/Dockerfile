FROM php:8.1.5-fpm-alpine

ENV COMPOSER_MEMORY_LIMIT='-1'

ARG GD_PARAMS="--with-freetype=/usr --with-jpeg=/usr"
ARG PHP_MOD_INSTALL="mysqli pdo_mysql intl curl soap exif zip sockets opcache bcmath gmp gd"

RUN apk add --no-cache --virtual \
    .build-deps \
    $PHPIZE_DEPS

RUN apk add --no-cache -- \
    icu \
    curl \
    libzip \
    bash \
    autoconf \
    libtool \
    freetype-dev \
    imagemagick6-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    icu-dev \
    pcre-dev \
    curl-dev \
    libxml2-dev \
    libzip-dev \
    libmemcached-dev \
    # telnet in busybox-extras
    busybox-extras \
    openssh \
    gmp-dev \
    libgomp \
        && pecl install Imagick \
        && docker-php-ext-enable imagick \
        && docker-php-ext-configure gd $GD_PARAMS \
        && docker-php-ext-install -j$(nproc) $PHP_MOD_INSTALL \
        && pecl install -o -f redis \
        && docker-php-ext-enable redis \
        && pecl install apcu \
        && docker-php-ext-enable apcu \
        && pecl install memcached \
        && docker-php-ext-enable memcached \
        && apk del .build-deps

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
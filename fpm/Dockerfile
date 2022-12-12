FROM composer
FROM php:8.2-fpm-alpine

RUN apk add --no-cache --virtual .build-deps \
        ${PHPIZE_DEPS} \
        git \
        freetype \
        libjpeg-turbo \
        freetype-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        icu-dev \
        zlib-dev \
        libzip-dev  \
        gmp-dev \
        libmemcached-dev \
        postgresql-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) pgsql pdo_pgsql intl opcache gmp gd zip \
    && pecl install apcu && docker-php-ext-enable apcu \
    && pecl install redis && docker-php-ext-enable redis \
    && pecl install memcached && docker-php-ext-enable memcached \
    && apk del ${PHPIZE_DEPS}

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]

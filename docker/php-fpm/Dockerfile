ARG PHP_VERSION
FROM php:${PHP_VERSION}-fpm-alpine

ARG MCRYPT_VERSION=1.0.3
ARG REDIS_VERSION=5.3.6
ARG MEMCACHED_VERSION=3.1.5
RUN apk upgrade --update && apk add --no-cache \
    g++ \
    gcc \
    curl \
    bash \
    make \
    autoconf \
    freetype-dev \
    libjpeg-turbo-dev \
	libpng-dev \
	oniguruma-dev \
	libzip-dev
RUN docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	  && docker-php-ext-configure gd --with-freetype --with-jpeg \
      && docker-php-ext-install -j$(nproc) gd \
    && apk add --no-cache libmemcached-dev  \
      && pecl install memcached-${MEMCACHED_VERSION} \
      && docker-php-ext-enable memcached \
    && pecl install redis-${REDIS_VERSION} \
	  && docker-php-ext-enable redis \
    && apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo \
      && docker-php-ext-install pdo_pgsql

COPY php.ini /usr/local/etc/php/conf.d/php-custom.ini

ARG WORKDIR
WORKDIR ${WORKDIR}

CMD ["php-fpm"]

FROM php:8.1-fpm

ENV NGINX_USER=www-data \
    NGINX_SITECONF_DIR=/etc/nginx/sites-enabled \
    NGINX_LOG_DIR=/var/log/nginx \
    NGINX_TEMP_DIR=/var/lib/nginx

RUN apt-get update -q -y \
    && apt-get install -q -y --no-install-recommends \
    libmemcached-dev zlib1g-dev \
    curl \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    zip \
    libmcrypt-dev \
    unzip \
    git \
    nginx \
    procps \
    sudo \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && rm -rf /var/lib/apt/lists/*

RUN apt-get update -q -y \
    && apt-get install -q -y --no-install-recommends \
    libzip-dev \
    zip \
    psmisc

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pgsql pdo_pgsql \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install zip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install sockets

COPY docker/php/php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /var/www
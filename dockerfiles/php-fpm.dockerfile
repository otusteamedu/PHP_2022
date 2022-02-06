FROM php:8.0.11-fpm

# Install system dependencies, memcached and redis
RUN apt-get update && apt-get install -y --no-install-recommends git \
    libpq-dev \
    libmemcached-dev \
    zip \
    unzip \
    zlib1g-dev \
&& docker-php-ext-install pgsql \
&& docker-php-ext-install pdo_pgsql \
&& pecl install memcached && \
    docker-php-ext-enable memcached \
&& pecl install redis && \
    docker-php-ext-enable redis

# Php.ini
COPY ./dockerfiles/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

# Set working directory
WORKDIR /var/www

COPY . .
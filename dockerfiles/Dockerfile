FROM php:8.0.11-fpm

# Set working directory
WORKDIR /var/www/mysite.local

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
    docker-php-ext-enable memcached

COPY . .

EXPOSE 9000

# Php.ini
COPY ./dockerfiles/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini
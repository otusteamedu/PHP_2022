FROM php:7.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    libmemcached-dev \
    &&  pecl install memcached \
    &&  docker-php-ext-enable memcached \
    &&  docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
    &&  pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY ./docker/php/local.ini /usr/local/etc/php/conf.d/php-custom.ini

# Set working directory
WORKDIR /var/www

CMD ["php-fpm"]
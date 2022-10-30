FROM php:8.1.12-fpm

RUN apt-get update && apt-get install -y \
    libonig-dev \
    libpq-dev \
    libzip-dev \
    libmemcached-dev \
    curl \
 && docker-php-ext-install pdo_pgsql zip \
 && pecl install redis memcached \
 && docker-php-ext-enable redis memcached \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]

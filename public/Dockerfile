FROM php:8.0-fpm

RUN apt-get update \
    && apt-get install -y git \
    && chmod +x /usr/local/bin/install-php-extensions && sync \
    && install-php-extensions pgsql \
    && install-php-extensions pdo_pgsql

WORKDIR /var/www

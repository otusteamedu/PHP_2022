FROM php:8.0-fpm
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN apt-get update && apt-get install -y git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
RUN apt-get update && chmod +x /usr/local/bin/install-php-extensions && sync \
    && install-php-extensions pgsql \
    && install-php-extensions pdo_pgsql
WORKDIR /var/www/html

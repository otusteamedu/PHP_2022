FROM php:7.2-fpm-alpine

COPY ./code/composer.json /app/composer.json
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

VOLUME /app
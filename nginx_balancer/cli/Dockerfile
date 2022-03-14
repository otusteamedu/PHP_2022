FROM php:7.4

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer --version && php -v
WORKDIR /app
COPY ./code/composer.json /app/composer.json
CMD composer install
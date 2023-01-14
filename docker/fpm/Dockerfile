FROM php:8.1-fpm

RUN apt-get update && apt-get install -y curl git zip \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

COPY --from=composer /usr/bin/composer /usr/bin/composer

CMD ["php-fpm"]

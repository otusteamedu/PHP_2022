FROM php:7.4-fpm

RUN apt-get update && apt-get install -y libpq-dev \
    libmemcached-dev \
    zlib1g-dev \
    && pecl install -of redis && docker-php-ext-enable redis \
    && pecl install -of memcached && docker-php-ext-enable memcached \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-enable pdo pdo_mysql

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]

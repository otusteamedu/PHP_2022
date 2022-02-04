FROM php:7.4-fpm

RUN apt-get update && apt-get install -y libpq-dev \
    libmemcached-dev \
    zlib1g-dev \
    && pecl install -of redis && docker-php-ext-enable redis \
    && pecl install -of memcached && docker-php-ext-enable memcached \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install sockets pdo_pgsql

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]

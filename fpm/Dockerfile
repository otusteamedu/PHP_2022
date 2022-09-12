FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev libonig-dev \
    libzip-dev libmemcached-dev libmcrypt-dev curl supervisor \
   && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip opcache sockets \
   && docker-php-ext-configure gd --with-freetype --with-jpeg \
   && docker-php-ext-install -j$(nproc) gd

RUN pecl install ds redis memcached xdebug \
   && docker-php-ext-enable ds redis memcached xdebug \
   && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN mkdir -p /var/log/supervisor

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY ./xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY ./error_reporting.ini /usr/local/etc/php/conf.d/error_reporting.ini
COPY ./supervisord.conf /etc/supervisord.conf
COPY ./entrypoint.sh /usr/local/bin/entrypoint.sh

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
   && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
   && rm composer-setup.php

ENV APP_ROOT=/data/application.local

WORKDIR $APP_ROOT
VOLUME $APP_ROOT

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]
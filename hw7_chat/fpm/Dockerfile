FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev libjpeg62-turbo-dev libpng-dev libonig-dev \
	    libzip-dev libmemcached-dev libmcrypt-dev curl \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip opcache sockets \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install memcached  \
    && docker-php-ext-enable memcached \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

ENV APP_ROOT=/data/application.local

WORKDIR $APP_ROOT
VOLUME $APP_ROOT

CMD ["php-fpm"]
FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
    libpq-dev \
    && pecl install mcrypt-1.0.4 \
	&& docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) iconv mbstring zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && rm /usr/local/etc/php-fpm.d/* \
    && curl -sS https://getcomposer.org/installer > composer-setup.php \
        && php composer-setup.php && rm composer-setup.php* \
        && chmod +x composer.phar && mv composer.phar /usr/bin/composer

COPY application.local.conf /usr/local/etc/php-fpm.d/

WORKDIR /www/application.local
VOLUME /www/application.local

CMD ["php-fpm"]
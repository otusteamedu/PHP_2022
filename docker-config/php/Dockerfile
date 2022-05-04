FROM php:8.0-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
    && pecl install mcrypt-1.0.4 \
	&& docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install memcache \
    && docker-php-ext-enable memcache \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && rm /usr/local/etc/php-fpm.d/* \
    && curl -sS https://getcomposer.org/installer > composer-setup.php \
        && php composer-setup.php && rm composer-setup.php* \
        && chmod +x composer.phar && mv composer.phar /usr/bin/composer

COPY php.ini /usr/local/etc/php/conf.d/php-custom.ini
COPY application.local.conf /usr/local/etc/php-fpm.d/

WORKDIR /www

VOLUME /www

CMD ["php-fpm"]

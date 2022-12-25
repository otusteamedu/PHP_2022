
FROM php:8.1-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
    curl \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmcrypt-dev \
    libmemcached-tools \
    libmemcached-dev \
        && pecl install mcrypt-1.0.5 && docker-php-ext-enable mcrypt \
        && pecl install redis && docker-php-ext-enable redis \
        && pecl install memcached && docker-php-ext-enable memcached \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	    && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd



RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./conf.d /usr/local/etc/php/conf.d

WORKDIR /app
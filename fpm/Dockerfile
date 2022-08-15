FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    curl \
    wget \
    git \
	libpng-dev \
	libpq-dev \
	libonig-dev \
	libzip-dev \
	libmcrypt-dev \
        && pecl install mcrypt-1.0.5 \
	&& docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring zip \
        && docker-php-ext-install -j$(nproc) gd \
        && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
        && docker-php-ext-configure pgsql && docker-php-ext-install pdo_pgsql pgsql


COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini


# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]

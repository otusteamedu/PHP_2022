FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev libjpeg62-turbo-dev libpng-dev libonig-dev \
	    libzip-dev libmemcached-dev libmcrypt-dev curl \
    && docker-php-ext-install iconv mbstring mysqli pdo_mysql zip opcache sockets \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && pecl install memcached  \
    && docker-php-ext-enable memcached \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
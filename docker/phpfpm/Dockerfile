FROM php:7.4-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
    redis-tools \
    && pecl install mcrypt-1.0.3 \
    && pecl install redis \
	&& docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install memcached  \
    && docker-php-ext-enable memcached \
    && docker-php-ext-enable redis


# настраиваем PHP-FPM как unix-socket
RUN echo 'listen = /run/php7.4-fpm.sock' >> /usr/local/etc/php-fpm.d/www.conf && \
    echo 'listen.owner = www-data' >> /usr/local/etc/php-fpm.d/www.conf && \
    echo 'listen.group = www-data' >> /usr/local/etc/php-fpm.d/www.conf && \
    echo 'listen.mode = 0660' >> /usr/local/etc/php-fpm.d/www.conf && \
    echo 'listen = /run/php7.4-fpm.sock' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'listen.owner = www-data' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'listen.group = www-data' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'listen.mode = 0660' >> /usr/local/etc/php-fpm.d/zz-docker.conf

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
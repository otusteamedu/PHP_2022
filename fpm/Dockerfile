FROM php:7.4-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
    curl \
    wget \
    git \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmcrypt-dev \
    autoconf \
    libevent-dev \
    bzip2 \
    libwebp-dev \
    postgresql \
    libmemcached-dev \
    libicu-dev \
    libpq-dev \
    && pecl install mcrypt-1.0.3 \
	&& docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip intl bcmath pdo_pgsql pcntl sockets \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install -o -f \
            redis \
            memcached \
        && rm -rf /tmp/pear \
        && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
        && echo "extension=memcached.so" > /usr/local/etc/php/conf.d/memcached.ini

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY www.conf /usr/local/etc/php-fpm.d/www.conf
RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /data
VOLUME /data

CMD ["php-fpm", "--nodaemonize"]

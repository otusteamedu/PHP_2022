FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        vim \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libonig-dev \
        libpq-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        supervisor \
        libzip-dev \
        memcached \
        libmemcached-tools \
        libmemcached-dev \
    && pecl install mcrypt-1.0.3 \
    && pecl install memcached \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) iconv mbstring pdo pdo_pgsql pgsql zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-enable mcrypt \
    && docker-php-ext-enable memcached

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD ./php.ini /usr/local/etc/php/conf.d/custom.ini
ADD ./php-fpm.conf /usr/local/etc/php-fpm.d/php-fpm.conf

WORKDIR /var/www

CMD bash -c "php-fpm";
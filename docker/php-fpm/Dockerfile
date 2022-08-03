FROM php:8.1-fpm

# copy fpm conf
COPY conf/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

# install php requirements
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libmemcached-dev && \
    pecl install memcached && \
    docker-php-ext-enable memcached

# install composer v2
RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

WORKDIR /app
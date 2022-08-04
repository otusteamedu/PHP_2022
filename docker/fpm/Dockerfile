FROM php:8.1-fpm

COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libmemcached-dev && \
    pecl install memcached && \
    docker-php-ext-enable memcached

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]

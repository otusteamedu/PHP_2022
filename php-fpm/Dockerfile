FROM php:7.4-fpm-alpine3.16

            
RUN apk update && apk add \             
        #пакеты для redis
        autoconf make gcc g++ \            
        #пакеты для memcached
        libmemcached-dev zlib-dev \ 
        #пакеты для postgres
        postgresql-dev \
    && pecl install memcached-3.1.5 \
    && docker-php-ext-enable memcached \
    && pecl install redis-5.3.7 \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pgsql pdo_pgsql
        

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /www/application.local

CMD ["php-fpm"]
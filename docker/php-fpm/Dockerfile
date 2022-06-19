ARG PHP_VERSION
FROM php:${PHP_VERSION}-fpm-alpine

ARG REDIS_VERSION=5.3.7
ARG MEMCACHED_VERSION=3.1.5
RUN apk upgrade --update && apk add --no-cache \
    g++ \
    gcc \
    curl \
    bash \
    make \
    autoconf \
    freetype-dev \
    libjpeg-turbo-dev \
	libpng-dev \
	oniguruma-dev \
	libzip-dev
RUN docker-php-ext-install -j$(nproc) mbstring zip \
	  && docker-php-ext-configure gd --with-freetype --with-jpeg \
      && docker-php-ext-install -j$(nproc) gd \
    && apk add --no-cache libmemcached-dev  \
      && pecl install memcached-${MEMCACHED_VERSION} \
      && docker-php-ext-enable memcached \
    && apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo \
      && docker-php-ext-install pdo_pgsql

RUN curl -L -f https://github.com/FriendsOfPHP/pickle/releases/latest/download/pickle.phar -o /usr/local/bin/pickle \
    && chmod +x /usr/local/bin/pickle \
    && pickle install redis-${REDIS_VERSION} \
    && docker-php-ext-enable redis.so


ARG WORKDIR
WORKDIR ${WORKDIR}

CMD ["php-fpm"]

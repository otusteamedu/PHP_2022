FROM php:8.1-fpm

ENV COMPOSER_VERSION 2.0.12
ENV COMPOSER_HOME /tmp
ENV COMPOSER_ALLOW_SUPERUSER 1


# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmemcached-dev \
	libmcrypt-dev \
    libpq-dev \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
     && pecl install memcached  \
       && docker-php-ext-enable memcached \
    && docker-php-source extract  \
       &&   pecl install redis \
        &&  docker-php-ext-enable redis  \
      &&    docker-php-source delete \
     && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && set -xe \
          && mkdir -p "$COMPOSER_HOME" \
          && php -r "copy('https://getcomposer.org/installer', '/tmp/composer-setup.php');" \
          && php /tmp/composer-setup.php --no-ansi --install-dir=/usr/bin --filename=composer --version=$COMPOSER_VERSION \
          && composer --ansi --version --no-interaction \
          && composer clear-cache \
          && rm -rf /tmp/composer-setup.php /tmp/.htaccess




COPY php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]

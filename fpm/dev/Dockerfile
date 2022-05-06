FROM touch4it/php8:latest

RUN apk update && apk add \
        libzip-dev \
        zip \
        libpq-dev \
        ssmtp \
  && pecl install xdebug \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && docker-php-ext-install zip \
     pdo \
     pdo_pgsql \
  && docker-php-ext-enable xdebug \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./php.ini /usr/local/etc/php/php.ini

WORKDIR /code

CMD ["php-fpm"]

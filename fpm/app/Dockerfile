FROM php:8.1-fpm

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]

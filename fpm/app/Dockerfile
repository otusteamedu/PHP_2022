FROM php:8.1-fpm

COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]

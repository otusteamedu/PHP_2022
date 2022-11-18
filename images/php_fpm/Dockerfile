FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        vim \
        curl \
        wget \
        git \
    && docker-php-ext-install sockets \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/app

CMD bash -c "php-fpm"

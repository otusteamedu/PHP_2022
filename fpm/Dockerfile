FROM php:8.1-fpm

WORKDIR /data

VOLUME /data

RUN apt-get -y update \
&& apt-get install -y libicu-dev \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl \
&& apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

CMD ["php-fpm"]

FROM php:7.4-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
    && docker-php-ext-install sockets

WORKDIR /data/mysite.local/

VOLUME /data/mysite.local/

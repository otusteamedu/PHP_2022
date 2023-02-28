FROM php:8.0-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y libpq-dev zlib1g-dev && docker-php-ext-install sockets


WORKDIR /data

VOLUME /data

CMD ["php-fpm"]

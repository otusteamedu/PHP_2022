FROM php:8.0-fpm

RUN apt-get update && apt-get install -y libpq-dev zlib1g-dev && docker-php-ext-install sockets

WORKDIR /chat-app

VOLUME /chat-app

CMD ["php-fpm"]

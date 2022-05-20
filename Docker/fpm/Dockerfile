FROM php:7.4-fpm

RUN apt-get update && apt-get install -y libpq-dev zlib1g-dev && docker-php-ext-install sockets

WORKDIR /chat-app

VOLUME /chat-app

CMD ["php-fpm"]

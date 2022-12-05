FROM php:7.4-cli

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /code

CMD [ "php", "./app.php" ]

FROM composer as vendor_installer
WORKDIR /app/
COPY composer.* ./
RUN composer install --ignore-platform-reqs --no-interaction

FROM php:8.1.0-cli

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends git \
    libpq-dev \
    zip \
    unzip

COPY . .
COPY ./dockerfiles/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini
COPY --from=vendor_installer /app/vendor /var/www/vendor

RUN chmod 777 vendor -R

#ENTRYPOINT ["php", "app.php"]
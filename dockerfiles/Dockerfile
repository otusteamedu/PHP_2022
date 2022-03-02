FROM php:8.0.11

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends git \
    libpq-dev \
    && docker-php-ext-install pgsql && \
       docker-php-ext-install pdo_pgsql

# Set working directory
WORKDIR /var/www

#Use custom php config
COPY . .
COPY ./dockerfiles/custom-php.ini /usr/local/etc/php/conf.d/custom-php.ini

ENTRYPOINT ["php", "index.php"]
ARG PHP_VERSION
FROM php:${PHP_VERSION}-cli

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

ARG WORKDIR
WORKDIR ${WORKDIR}

VOLUME ${WORKDIR}/vendor

COPY composer.json composer.lock ./

RUN composer install \
--no-interaction \
--no-plugins \
--no-scripts \
--no-dev \
--prefer-dist
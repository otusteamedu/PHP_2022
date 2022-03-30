FROM php:8.0-fpm-buster

MAINTAINER decole <decole2014@yandex.ru>

ENV BASE_PATH="/var/www" \
    MODE="production" \
    PATH=/composer/vendor/bin:/scripts:/scripts/aliases:$PATH \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_CACHE_DIR="/tmp" \
    COMPOSER_HOME="/composer" \
    XDEBUG_CLIENT_HOST="172.17.0.1"

RUN DEBIAN_FRONTEND=noninteractive apt-get update \
    && apt upgrade -y \
    && apt install -y --no-install-recommends \
        locales \
        bash \
        git \
        nano \
        libfreetype6-dev \
        libxml2-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        zlib1g-dev \
        libzip-dev \
        libz-dev \
        libpq-dev  \
        libsqlite3-dev  \
        libicu-dev \
        zip \
        libmcrypt-dev \
        libvpx-dev \
        libjpeg-dev \
        libpng-dev \
        bzip2 \
        wget \
        libexpat1-dev \
        libbz2-dev \
        libgmp3-dev \
        libldap2-dev \
        unixodbc-dev \
        libsnmp-dev \
        libpcre3-dev \
        libtidy-dev \
        libaspell-dev \
        tar \
        libcurl4-gnutls-dev \
        apt-utils \
        libxrender1 \
        unzip \
        libonig-dev \
        libldap2-dev \
        libxslt-dev \
        libwebp-dev \
        libc-client-dev \
        libkrb5-dev \
        libpspell-dev \
        librabbitmq-dev \
        librabbitmq4 \
        supervisor \
    && phpModules=" \
                bcmath \
                bz2 \
                calendar \
                exif \
                gd \
                gettext \
                gmp \
                imap \
                intl \
                ldap \
                mysqli \
                opcache \
                pcntl \
                pdo_mysql \
                pdo_pgsql \
                pgsql \
                pspell \
                shmop \
                snmp \
                soap \
                sockets \
                sysvmsg \
                sysvsem \
                sysvshm \
                tidy \
                xsl \
                zip \
            " \
    && docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-configure intl  \
    && docker-php-ext-configure zip  \
    && docker-php-ext-configure pdo_pgsql  \
    && docker-php-ext-install -j$(nproc) $phpModules \
    && pecl install xdebug-3.1.2 \
    && pecl install redis-5.3.6 \
    && pecl install apcu-5.1.21 \
    && pecl install igbinary-3.2.7 \
    && docker-php-ext-enable xdebug redis apcu igbinary

COPY docker-compose/php/local.ini /usr/local/etc/php/conf.d/local.ini

RUN echo -e "\n\n====================== Remove unised ======================\n" \
    && apt-get autoremove gcc -y \
    && apt-get clean all \
    && rm -rvf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && dpkg -la | awk '{print $2}' | grep '\-dev' | xargs apt-get remove -y \
    && rm -rf /tmp/*

WORKDIR /var/www

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

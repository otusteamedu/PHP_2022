FROM php:8.1-fpm

# Устанавливаем рабочую директорию
WORKDIR /var/www/app

# Установка некоторых необходимых пакетов
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libpq-dev \
    locales \
    vim \
    libzip-dev \
    libmemcached-dev

# Чистим кэш, чтобы уменьшить размер образа
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Устанавливаем необходимые php зависимости
RUN pecl install -o -f redis memcache xdebug \
    && docker-php-ext-configure zip \
    && docker-php-ext-enable redis memcache xdebug \
    && docker-php-ext-install pdo_pgsql mbstring zip \
    && rm -rf /tmp/pear

# Устанавливаем composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
FROM php:8.1-fpm

# Устанавливаем рабочую директорию
WORKDIR /var/www/app

# Установка некоторых необходимых пакетов
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libpq-dev \
    locales \
    vim

# Чистим кэш, чтобы уменьшить размер образа
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Устанавливаем необходимые php зависимости
RUN docker-php-ext-install pdo_pgsql mbstring

# Устанавливаем composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
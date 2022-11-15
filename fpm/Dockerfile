# Собираю образ на основе fedora, так как в ней есть все модули php под arm архитектуру
FROM fedora:34

# Установка php и расширений
RUN yum -y install https://rpmfind.net/linux/fedora/linux/releases/34/Everything/aarch64/os/Packages/p/php-7.4.16-1.fc34.aarch64.rpm \
   php \
   php-bcmath \
   php-xml \
   php-pear \
   php-pgsql \
   php-gd \
   php-soap \
   php-pdo \
   php-redis \
   php-mbstring \
   php-mcrypt \
   php-soap \
   php-devel \
   php-process \
   php-zip \
   php-gmp \
   php-fpm \
   php-pecl-memcached \
   php-ast \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=bin --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && composer self-update  \
    && mkdir /data

# Глобальные настройки
COPY ./php-fpm.conf /etc/php-fpm.conf
COPY pool.conf /etc/php-fpm.d/www.conf
COPY ./php.ini /usr/local/etc/php/conf.d/php-custom.ini

WORKDIR /data

CMD ["/usr/sbin/php-fpm", "--nodaemonize", "--force-stderr" ,"--fpm-config", "/etc/php-fpm.conf"]

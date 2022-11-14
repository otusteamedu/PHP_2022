FROM nginx:1.23.2-alpine

COPY ./nginx-1/conf.d /etc/nginx/conf.d

RUN sed -i "s/nginx-1/nginx-2/g" /etc/nginx/conf.d/default.conf \
    && sed -i "s/php-fpm-1/php-fpm-2/g" /etc/nginx/conf.d/default.conf

WORKDIR /app
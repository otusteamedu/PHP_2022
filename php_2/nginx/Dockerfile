FROM nginx:latest

COPY ./hosts/php_2.conf /etc/nginx/conf.d/php_2.conf

WORKDIR /data/php_2
VOLUME /data/php_2
EXPOSE 81
CMD ["nginx", "-g", "daemon off;"]

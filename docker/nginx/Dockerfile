FROM nginx:latest

COPY hosts/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/application.local

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
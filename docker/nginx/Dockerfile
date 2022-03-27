FROM ubuntu:latest

RUN apt-get update

RUN apt-get install -y nginx

WORKDIR /var/www

VOLUME /var/www/application.local

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
FROM nginx:latest

COPY hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /data  

VOLUME /data  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

#FROM ubuntu:latest
#
#RUN apt-get update
#
#RUN apt-get install -y nginx
#
#WORKDIR /var/www
#
#VOLUME /var/www/application.local
#
#EXPOSE 80
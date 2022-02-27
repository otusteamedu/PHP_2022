FROM ubuntu:latest

RUN apt-get update  

RUN apt-get install -y nginx  

COPY ./hosts/otus.local.conf /etc/nginx/sites-enabled/otus.local.conf

WORKDIR /data  

VOLUME /data  

CMD ["nginx", "-g", "daemon off;"]
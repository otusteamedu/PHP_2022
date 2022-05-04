FROM ubuntu:latest

RUN apt-get update  

RUN apt-get install -y nginx

COPY ./hosts/l.conf /etc/nginx/sites-enabled/l.conf

WORKDIR /code

VOLUME /code

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
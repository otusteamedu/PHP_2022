FROM ubuntu:latest

RUN apt-get update

RUN apt-get install -y nginx

COPY ./hosts/email-verification.local.conf /etc/nginx/sites-enabled/email-verification.local.conf

WORKDIR /data

VOLUME /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
FROM ubuntu:latest
RUN apt-get update
RUN apt-get install -y nginx

COPY ./hosts/misite.local.conf /etc/nginx/conf.d/misite.local.conf

WORKDIR /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

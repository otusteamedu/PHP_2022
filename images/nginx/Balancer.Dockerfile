FROM ubuntu:latest

RUN apt-get update && \
    apt-get install -y nginx

COPY hosts/balancer.conf /etc/nginx/conf.d/balancer.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
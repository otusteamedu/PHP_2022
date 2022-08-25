FROM nginx:latest

RUN apt-get update && apt-get install -y mc

COPY ./hosts/default.conf /etc/nginx/conf.d/default.conf
COPY ./nginx/nginx.conf /etc/nginx/nginx.conf

WORKDIR /data

VOLUME /data  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
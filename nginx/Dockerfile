FROM nginx:latest

RUN apt-get update && apt-get install -y mc

COPY ./hosts/default.conf /etc/nginx/conf.d/default.conf
WORKDIR /data/application.local
CMD ["nginx", "-g", "daemon off;"]
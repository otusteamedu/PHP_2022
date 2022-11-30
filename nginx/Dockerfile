FROM nginx:latest

RUN apt update && apt install -y mc

# COPY ./hosts/application.local.conf /etc/nginx/conf.d/application.local.conf
COPY ./hosts/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /data/application.local

CMD ["nginx", "-g", "daemon off;"]
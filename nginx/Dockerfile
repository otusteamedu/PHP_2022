FROM nginx:latest

RUN apt update && apt install -y mc

# COPY ./hosts/application.local.conf /etc/nginx/conf.d/application.local.conf
COPY ./hosts/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /data/application.local
# EXPOSE 80;
CMD ["nginx", "-g", "daemon off;"]
FROM nginx:latest

RUN apt-get update && apt-get install -y mc

COPY ./hosts/application.local.conf /etc/nginx/conf.d/application.local.conf
# COPY ./nginx/nginx.conf /etc/nginx/nginx.conf

WORKDIR /data/application.local

#VOLUME /data

#EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
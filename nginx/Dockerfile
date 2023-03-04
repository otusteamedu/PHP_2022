FROM nginx:latest

COPY ./hosts/application.local.conf /etc/nginx/conf.d/application.local.conf

WORKDIR /data

VOLUME /data

EXPOSE 82

CMD ["nginx", "-g", "daemon off;"]

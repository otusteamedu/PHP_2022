FROM nginx:latest

COPY ./hosts/app.loc.conf /etc/nginx/conf.d/default.conf

WORKDIR /data

VOLUME /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
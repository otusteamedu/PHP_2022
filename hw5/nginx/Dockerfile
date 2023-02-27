FROM nginx:latest

COPY ./hosts/hw5.conf /etc/nginx/conf.d/hw5.conf

WORKDIR /data  

VOLUME /data  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
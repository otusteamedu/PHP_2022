FROM nginx:latest

COPY ./hosts/hw1.local.conf /etc/nginx/conf.d/hw1.local.conf

WORKDIR /data  

VOLUME /data  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
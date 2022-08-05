FROM nginx:latest

COPY ./hosts /etc/nginx/conf.d

WORKDIR /data  

VOLUME /data  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
FROM nginx:latest

COPY ./hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf
COPY ./hosts/nginx1.conf /etc/nginx/conf.d/nginx1.conf
COPY ./hosts/nginx2.conf /etc/nginx/conf.d/nginx2.conf

WORKDIR /data  

VOLUME /data  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
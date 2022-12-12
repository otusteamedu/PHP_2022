FROM nginx:1.23.2-alpine

COPY ./hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /data  

VOLUME /data  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
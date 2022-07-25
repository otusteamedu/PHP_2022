FROM nginx:1.22.0

COPY ./hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /data  

VOLUME /data

CMD ["nginx", "-g", "daemon off;"]
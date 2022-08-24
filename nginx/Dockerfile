FROM nginx:latest

COPY ./hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf
COPY ./hosts/frontend.local.conf /etc/nginx/conf.d/frontend.local.conf

WORKDIR /data/mysite.local

VOLUME /data/mysite.local
VOLUME /data/backend

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

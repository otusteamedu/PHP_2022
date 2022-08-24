FROM nginx:latest

COPY ./hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf
COPY ./hosts/frontend.local.conf /etc/nginx/conf.d/frontend.local.conf

VOLUME /data/mysite.local
VOLUME /data/sockets
VOLUME /data/backend
VOLUME /data/frontend

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

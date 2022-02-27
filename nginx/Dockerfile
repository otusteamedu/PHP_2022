FROM nginx:latest

# проброс из docker-compose.yml
# COPY hosts/app1.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /data

VOLUME /data

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
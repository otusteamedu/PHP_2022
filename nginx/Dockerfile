FROM nginx:1.23.1   

COPY ./vhosts/application.local.conf /etc/nginx/conf.d/application.local.conf

WORKDIR /www/application.local  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
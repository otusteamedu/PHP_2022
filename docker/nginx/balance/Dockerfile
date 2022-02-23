FROM nginx:stable

COPY mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /var/www

VOLUME /var/www/mysite.local

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

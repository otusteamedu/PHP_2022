FROM debian

RUN apt update && apt install -y nginx && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime \
    && echo $TZ > /etc/timezone

WORKDIR /var/www

COPY ./hosts/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf

EXPOSE 80

CMD [ "nginx", "-g", "daemon off;" ]
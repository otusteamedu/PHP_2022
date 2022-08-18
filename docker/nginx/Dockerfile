FROM nginx:latest

COPY ./hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

WORKDIR /data/mysite.local
<<<<<<< HEAD

VOLUME /data/mysite.local

EXPOSE 80

=======
VOLUME /data/mysite.local
EXPOSE 80
>>>>>>> origin/SBobrinev/master
CMD ["nginx", "-g", "daemon off;"]

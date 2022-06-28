FROM nginx:1.22.0

COPY nginx-balancer/hosts/balancer.mysite.local.conf /etc/nginx/conf.d/balancer.mysite.local.conf

WORKDIR /data  

VOLUME /data  

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
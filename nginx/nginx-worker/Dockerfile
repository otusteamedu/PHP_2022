FROM nginx:1.22.0

COPY nginx-worker/hosts/worker.mysite.local.conf /etc/nginx/conf.d/worker.mysite.local.conf

WORKDIR /data  

VOLUME /data

CMD ["nginx", "-g", "daemon off;"]
FROM nginx:latest


EXPOSE 80
RUN rm -f /etc/nginx/conf.d/default.conf

COPY ./conf.d /etc/nginx/conf.d


CMD ["nginx", "-g", "daemon off;"]

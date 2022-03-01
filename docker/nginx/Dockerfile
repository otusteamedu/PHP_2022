ARG NGINX_VERSION=stable
FROM nginx:${NGINX_VERSION}-alpine

RUN apk update \
    && apk add nginx \
    && rm /etc/nginx/conf.d/default.conf

ARG WORKDIR
WORKDIR ${WORKDIR}

CMD ["nginx", "-g", "daemon off;"]

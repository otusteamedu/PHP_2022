ARG NGINX_VERSION=stable
FROM nginx:${NGINX_VERSION}-alpine

RUN apk update \
    && apk add nginx

COPY hosts/mysite.local.conf /etc/nginx/conf.d/default.conf

ARG WORKDIR
WORKDIR ${WORKDIR}

CMD ["nginx", "-g", "daemon off;"]

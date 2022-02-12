FROM ubuntu:latest

RUN apt-get update \
    && apt-get install memcached -y

WORKDIR /data

VOLUME /data

CMD ["memcached", "-u", "memcache"]
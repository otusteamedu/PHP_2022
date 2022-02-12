FROM ubuntu:latest

RUN apt-get update

RUN apt-get install redis-server -y \
    && echo 'supervised systemd' >> /etc/redis/redis.conf && \
    service redis-server restart

WORKDIR /data

VOLUME /data

CMD ["redis-server", "--protected-mode no"]
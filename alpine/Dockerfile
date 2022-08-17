FROM alpine:3.16.2

RUN apk update && apk add \
    bash-completion \
    bc

COPY ./scripts /usr/local/bin

RUN chmod +x -R /usr/local/bin

WORKDIR /data

ENTRYPOINT ["tail", "-f", "/dev/null"]

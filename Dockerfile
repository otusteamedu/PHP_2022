FROM alpine:latest

RUN apk update && apk add --no-cache \
    nano \
    vim \
    sudo \
    bash-completion \
    bc

COPY . /project

WORKDIR /project

CMD ["/bin/bash"]

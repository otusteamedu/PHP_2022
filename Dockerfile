FROM alpine:latest

RUN apk update && apk add --no-cache \
    sudo \
    bash-completion \
    bc

COPY . /project

WORKDIR /project

CMD ["/bin/bash"]

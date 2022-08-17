FROM alpine:latest

RUN apk update && apk add --no-cache \
    bash-completion \
    bc

COPY sum.sh /project/sum.sh

WORKDIR /project

CMD ["/bin/bash"]

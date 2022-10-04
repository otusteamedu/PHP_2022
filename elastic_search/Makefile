#!/bin/sh

compose = docker-compose

create_certs:
    $(compose) -f create-certs.yml run --rm create_certs
build:
	$(compose) up -d --build --remove-orphans
down:
	$(compose) down
up:
	$(compose) up -d
stop:
	$(compose) stop
restart: down up
run:
	$(compose) run es-search bash



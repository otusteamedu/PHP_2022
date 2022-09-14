#!/bin/sh

compose = docker-compose

build-app:
	$(compose) up -d --build --remove-orphans
down-app:
	$(compose) down
up-app:
	$(compose) up -d
stop-app:
	$(compose) stop
restart-app: down-app up-app
run-server:
	$(compose) run socket-chat-server bash
run-client:
	$(compose) run socket-chat-client bash



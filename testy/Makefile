#!/bin/sh

compose = docker-compose

build:
	$(compose) up -d --build --remove-orphans
down:
	$(compose) down
up:
	$(compose) up -d
kill:
	$(compose) down -v && rm -rf data/elastic/nodes/*
restart: down up
run:
	$(compose) run php sh
SHELL := /bin/bash

up:
	docker-compose --env-file ./code/.env  up -d

build:
	docker-compose --env-file ./code/.env up -d --build

down:
	docker-compose --env-file ./code/.env down

.PHONY: up
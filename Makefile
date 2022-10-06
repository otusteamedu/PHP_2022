SHELL := /bin/bash

up:
	sudo sysctl -w vm.max_map_count=262144
	docker-compose --env-file ./code/.env  up -d

build:
	docker-compose --env-file ./code/.env up -d --build

down:
	docker-compose --env-file ./code/.env down

.PHONY: up
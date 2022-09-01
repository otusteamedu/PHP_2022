SHELL := /bin/bash

up:
	docker-compose up -d
	sudo --prompt=03101977 chmod -R 777 socket

build:
	docker-compose up -d --build
	sudo --prompt=03101977 chmod -R 777 socket

down:
	docker-compose down

.PHONY: up
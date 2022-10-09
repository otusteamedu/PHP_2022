SHELL := /bin/bash

up:
	docker-compose up -d

build:
	docker-compose up -d --build

down:
	docker-compose down

.PHONY: up
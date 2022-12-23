#!/bin/bash

docker-compose down -v --remove-orphans
docker-compose build --no-cache
docker-compose up -d
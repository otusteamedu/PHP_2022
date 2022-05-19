#!/bin/bash
#docker-compose down  --remove-orphans && docker-compose build --no-cache && docker-compose up -d
docker-compose down --remove-orphans && docker-compose up -d --build
#docker-compose down && docker-compose up -d

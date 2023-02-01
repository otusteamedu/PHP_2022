#!/usr/bin/env bash

POSTGRES_DB="test"
POSTGRES_USER="user"

# разворачиваем таблички
docker compose exec postgres psql -U $POSTGRES_USER -d $POSTGRES_DB -a -f ./DDL/tables.sql

# функции
docker compose exec postgres psql -U $POSTGRES_USER -d $POSTGRES_DB -a -f ./DDL/random_string.sql

# генератор
docker compose exec postgres psql -U $POSTGRES_USER -d $POSTGRES_DB -a -f ./DDL/generator_10000.sql


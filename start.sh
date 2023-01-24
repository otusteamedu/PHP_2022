#!/usr/bin/env bash

POSTGRES_DB="test"
POSTGRES_USER="user"
POSTGRES_PASSWORD="pass"

#разворачиваем таблички
docker compose exec postgres psql -U $POSTGRES_USER -d $POSTGRES_DB -a -f ./app/DDL/movies.sql
docker compose exec postgres psql -U $POSTGRES_USER -d $POSTGRES_DB -a -f ./app/DDL/aev_types.sql
docker compose exec postgres psql -U $POSTGRES_USER -d $POSTGRES_DB -a -f ./app/DDL/aev_attributes.sql
docker compose exec postgres psql -U $POSTGRES_USER -d $POSTGRES_DB -a -f ./app/DDL/aev_values.sql

#наполнение данными
docker compose exec postgres psql -U $POSTGRES_USER -d $POSTGRES_DB -a -f ./app/DML/movies.sql
docker compose exec postgres psql -U $POSTGRES_USER -d $POSTGRES_DB -a -f ./app/DML/aev_types.sql
docker compose exec postgres psql -U $POSTGRES_USER -d $POSTGRES_DB -a -f ./app/DML/aev_attributes.sql
docker compose exec postgres psql -U $POSTGRES_USER -d $POSTGRES_DB -a -f ./app/DML/aev_values.sql
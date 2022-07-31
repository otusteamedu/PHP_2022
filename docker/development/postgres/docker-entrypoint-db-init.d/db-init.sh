#!/bin/bash

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
  CREATE ROLE "$POSTGRES_ROLE" LOGIN PASSWORD "$POSTGRES_PASSWORD";
  GRANT ALL PRIVILEGES ON DATABASE "$POSTGRES_DB" TO "$POSTGRES_USER";
EOSQL

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" <<-EOSQL
SELECT (
    CREATE DATABASE "$POSTGRES_DB"
    WITH
      OWNER "$POSTGRES_USER"
      ENCODING = 'UTF8'
)
WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = "$POSTGRES_DB")\gexec
EOSQL

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
  CREATE EXTENSION pg_stat_statements;
EOSQL

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
  CREATE EXTENSION IF NOT EXISTS pg_trgm;
  ALTER EXTENSION pg_trgm SET SCHEMA public;
  UPDATE pg_opclass SET opcdefault = true WHERE opcname='gin_trgm_ops';
EOSQL

#!/bin/sh

until PGPASSWORD=${POSTGRES_PASSWORD} psql -q -h ${POSTGRES_HOST} -U ${POSTGRES_USER} -c '\q'; do
  >&2 echo "Postgres is unavailable - sleeping"
  sleep 5
done

>&2 echo "Postgres is up!"
exec "$@"

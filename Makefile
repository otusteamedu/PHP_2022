APP_ENV ?=dev
$(shell cp -n .env.${APP_ENV}.dist .env)
$(shell cp -n app/.env.dist app/.env)
$(shell mkdir -p app/var/cache)

include ./.env
export $(shell sed 's/=.*//' ./.env)

-include ./make/${APP_ENV}/**/*.mk
-include ./make/${APP_ENV}/*.mk

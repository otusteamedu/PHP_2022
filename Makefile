APP_ENV ?=development
$(shell cp -n .env.${APP_ENV}.dist .env)

include ./.env
export $(shell sed 's/=.*//' ./.env)

-include ./make/common/**/*.mk
-include ./make/${APP_ENV}/**/*.mk
-include ./make/${APP_ENV}/*.mk

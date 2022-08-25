$(shell cp -n .env.dist .env)

include ./.env
export $(shell sed 's/=.*//' ./.env)

-include ./make/**/*.mk
-include ./make/*.mk

list available commands
docker compose run --rm php-cli php bin/app.php

test connection
docker compose run --rm php-cli php bin/app.php test

get client                                              clientId
docker compose run --rm php-cli php bin/app.php get_client 234

get client tickets                                              clientId
docker compose run --rm php-cli php bin/app.php get_client_tickets 2134
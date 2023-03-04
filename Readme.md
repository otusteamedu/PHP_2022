list available commands
docker compose run --rm php-cli php bin/app.php

test connection
docker compose run --rm php-cli php bin/app.php test

get client                                              clientId
docker compose run --rm php-cli php bin/app.php get_client 234

get client tickets                                              clientId
docker compose run --rm php-cli php bin/app.php get_client_tickets 2134

update client                                                  id       string         phone  
docker compose run --rm php-cli php bin/app.php update_client 2134  email@email.com  +71234567890
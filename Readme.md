list available commands
docker compose run --rm php-cli php bin/app.php

test connection
docker compose run --rm php-cli php bin/app.php test

search                                           cmd     index   field  query
docker compose run --rm php-cli php bin/app.php search otus-shop title "рыцори"

                                                                        optional params: document & type, required for 
create index/table                                                      including russian analyzer for them
docker compose run --rm php-cli php bin/app.php create otus-shop2 title string

delete index/table
docker compose run --rm php-cli php bin/app.php delete otus-shop2

print index/table
docker compose run --rm php-cli php bin/app.php delete otus-shop


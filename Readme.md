list available commands
docker compose run --rm php-cli php bin/app.php

test connection
docker compose run --rm php-cli php bin/app.php test

search                                           cmd     index   query(json string)
docker compose run --rm php-cli php bin/app.php search otus-shop '{"query":{"match":{ "category": "Фантастика"} } }'

docker compose run --rm php-cli php bin/app.php search otus-shop "$(cat ./queries/search.json)"


                                                                        
create index/table                                                 query(json string)
docker compose run --rm php-cli php bin/app.php create otus-shop2 "$(cat ./queries/mapping.json)"

delete index/table
docker compose run --rm php-cli php bin/app.php delete otus-shop2

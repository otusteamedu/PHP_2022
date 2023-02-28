set storage in /src/config/storage.php

list available commands
docker compose run --rm php-cli php bin/app.php

test connection
docker compose run --rm php-cli php bin/app.php test

add events                                                event  priority  conditions 
docker compose run --rm php-cli php bin/app.php event_add event1 1000 param1:1
docker compose run --rm php-cli php bin/app.php event_add event2 2000 param1:2 param2:2
docker compose run --rm php-cli php bin/app.php event_add event3 3000 param1:1 param2:2

get event                                                     conditions 
docker compose run --rm php-cli php bin/app.php event_get param1:1 param2:2

flush all
docker compose run --rm php-cli php bin/app.php flush_all
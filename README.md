PHP Developer. Professional

# Чат на сокетах

Чат на unix сокетах между двумя контейнерами php

## Использование

Запуск контейнеров
```cmd
composer install
docker-compose up -d
```

Запуск сервера
```cmd
docker exec -it application_server php app.php server
```

Запуск клиента, во второй консоли
```cmd
docker exec -it application_client php app.php client
```

Выход из приложений - передать в чат "exit"
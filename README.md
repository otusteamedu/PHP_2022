# PHP_2022

### Инструкция по развертыванию системы

1) поднять контейнеры: ``` docker-compose up -d ```
2) Отправить запрос для получения статистики банковского счета. Пример запроса курлом: ``` curl --location 'http://localhost:8083/bank-account/statistics/generate' --header 'Content-Type: application/x-www-form-urlencoded' --data-urlencode 'date-start=2020-01-01' --data-urlencode 'date-end=2021-01-01' ```
3) Зайти в контейнер консъюмера: ``` docker-compose exec php-consumer bash```
4) Запустить команду для обработки входящих сообщений: ``` bin/console queue:consume```
5) На экране появится информация по обработке сообщения

#### Обработка входящих запросов происходит внутри контейнера ```php-fpm_1```, обработка сообщений из очереди в ``` php-consumer``` 
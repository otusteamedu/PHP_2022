1. Заполнить переменные окружения в файлах:
* consumer/.env
* publisher/www/application.local/.env

2. Добавить хост application.local в /etc/hosts
3. Запустить контейнеры:
```
docker-compose up -d
```
4. Запустить consumer:
```
docker exec -it php_2022_consumer_1 bash
```
, затем внутри контейнера:
```
php index.php
```
6. Перейти по адресу http://application.local
7. Заполнить форму, отправить
8. Наблюдать за результатом обработки в контейнере.

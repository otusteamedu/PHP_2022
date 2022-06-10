#!/bin/bash

#1. Переходим в директорию проекта
cd project

#2. Скачиваем изменения
git pull

#3. Перезапускаем docker-compose
docker-compose up -d --build --force-recreate -V

#4. Выполняем миграции
docker exec php_otus php bin/console doctrine:migrations:migrate

#5. Очистка кеша
docker exec php_otus php bin/console --env=prod cache:clear

#Изменения внесены!

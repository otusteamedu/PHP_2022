#!/bin/bash

#1. Переходим в директорию проекта
cd project

#2. Скачиваем изменения
git pull

#3. Перезапускаем docker-compose
docker-compose up -d --build --force-recreate -V

#4. Выполняем миграции
docker-compose exec php_otus php bin/console doctrine:migrations:migrate

#Изменения внесены!

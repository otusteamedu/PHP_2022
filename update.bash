#!/bin/bash

#1. Переходим в директорию проекта
cd project

#2. Скачиваем изменения
git pull

#3. Ложим докер
docker-compose down

#4. Запускаем докер
docker-compose up -d

#6. Выполняем миграции
docker-compose exec php_otus php bin/console doctrine:migrations:migrate

#Изменения внесены!

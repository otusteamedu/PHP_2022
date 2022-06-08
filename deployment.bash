#!/bin/bash

#1. Качаем установочные файлы с репозитория
git clone git@github.com:masteritua/deployment.git project

#2. Переходим в директорию проекта
cd project

#3. Копируем файл настроек .env.prod в .env
cp .env.prod.example .env

#4. Запускаем докер
docker-compose up -d

#5. Инициализируем композер
docker-compose exec php_otus composer install

#6. Выполняем миграции
docker-compose exec php_otus php bin/console doctrine:migrations:migrate

#Проект поднят!

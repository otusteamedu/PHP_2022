# Инструкция по развёртыванию системы

1. Клонировать проект ```git clone https://github.com/otusteamedu/PHP_2022.git```
2. Подтянуть зависимости ```cd code; composer install```
3. Создать бота и группу в Telegram. Добавить в нёё бота
4. Создать ```.env``` в корневой директории и заполнить на основе ```.env.example```
5. Запустить ```docker-compose up -d --build```
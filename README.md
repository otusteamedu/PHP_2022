# PHP_2022

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

-------

Домашнее задание
Анализ кода

Цель:
- Применить на практике изученные принципы;
- Научиться работать над аналитическими задачами в отношении кода.

Описание/Пошаговая инструкция выполнения домашнего задания:
1. Выберите один из своих проектов. 
2. Проведите анализ на предмет соответствия изученным принципам.
3. Предложите свои варианты исправления.

-------

1. ДЗ по сокетам
2. Анализ:
   - Client, Server и Socket не сущности, а консольные контроллеры команд, не нужно их помещать в папку Entity
   - Socket - это сервис, которым будут пользоваться Client и Server cli контроллеры
   - Log - сервис вывода данных на экран
3. Используя подход DDD, приложение было разделено на сервисы, Dto и консольные команды. 
   В слой инфраструктуры вынесены консольные команды, точки входа в приложение.
   В слой приложения вынесены конфигурационный класс и сервисы для работы с приложением.
   В слой домена вынесены Dto и контракт для Dto, что-то больше вынести в слой домена не получилось ибо 
   приложение маленькое.
   Через Dto пробрасываются данные, которые нужны для работы сервиса.

-------

# How it uses: 

### Get composer libs

`docker-compose run workspace  bash`

in container execute this:

`composer install`

-------

### Start server:

`docker-compose run socket-server bash`

in container execute this:

`php server.php`

-------

### Start client

> Start only after server container

`docker-compose run socket-client bash php client.php`

in container execute this:

`php client.php`

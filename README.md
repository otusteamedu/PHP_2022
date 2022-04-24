# PHP_2022

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus


## API:
1. `POST /event/add` добавлять новое событие в систему хранения событий
2. `GET /events/flush` очищать все доступные события
3. `POST /events/find` отвечать на запрос пользователя наиболее подходящим событием

[HW13.postman_collection.json](HW13.postman_collection.json) - коллекция для Postman


## Спец требования:
Слой кода, отвечающий за работу с хранилищем должен позволять легко менять хранилище.

Слой - StorageService.php - из .env берется параметр STORAGE, реализован STORAGE=redis, чтобы использовать memcached, 
нужно в .env написать STORAGE=memcached, и реализовать в папке src/Core/Repositories репозиторий
MemcachedStorageRepository.php


Сделано так, что название в STORAGE берется параметр, StorageService.php, делает uppercase и 
добавляет StorageRepository.php 


Таким образом решается простое добавление репозитория, без изменения основного кода.


## URL:

http://application.local - API

http://application.local:8001/ - RedisInsight

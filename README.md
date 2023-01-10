# Курс OTUS PHP_2022, ДЗ к Уроку №15: "Паттерны работы с данными"

## Автор
Mikhail Ikonnikov , mishaikon@gmail.com

## Задача

### Цель
Научиться применять на практике востребованные паттерны работы с хранилищами.

### Описание/пошаговая инструкция выполнения домашнего задания

Необходимо реализовать один из паттернов: 
- Table Data Gateway, 
- Raw Data Gateway, 
- Active Record, 
- DataMapper 
для произвольной таблицы. 

Паттерн должен содержать метод массового получения информации 
из таблицы, результат которого возвращается в виде коллекции.
Дополнительно можно использовать паттерн Identity Map 
для устранения дублирования объектов, ссылающихся на одну строку 
в БД или Lazy Load для отложенной загрузки связанных записей 
в таблице или коллекции.

### Критерии оценки:
Основная задача - реализация одного из перечисленных паттернов 
на произвольной таблице.
- Желательно реализовать метод массового получения информации.
- Желательно реализовать один из паттернов: 
Identity Map или Lazy Load.

------------------------------------------

### Описание

Реализуем на практике паттерны ``Identity Map`` и ``Data Mapper``

### Установка
``` 
git clone https://github.com/otusteamedu/PHP_2022.git
cd PHP_2022
git checkout MIkonnikov_hw15_db_patterns

# copy sources
cp .env.example .env
cd app
cp .env.example .env
cd ../

docker-compose build
docker-compose up -d
```

### Загрузка дампа БД
```
docker exec -it postgres bash
psql app_db < /tmp/create.sql 
``` 

### Файлы конфигурации

#### Конфигурация инфраструктуры

В корне проекта в файле .env описываются
переменные окружения Docker-инфраструктуры

#### Конфигурация проекта

В корне директории /app в файле .env
описываются переменные окружения приложения

### Запуск
```
docker exec -it app bash
php index.php
```

### Результат запуска (пример)
```
DATA MAPPER
[
    {
        "id": 1,
        "name": "TestCompany",
        "address": "Moscow",
        "phone": "+79250028756",
        "email": "test@mail.com"
    },
    {
        "id": 2,
        "name": "TestCompany",
        "address": "Moscow",
        "phone": "+79250028756",
        "email": "test@mail.com"
    },
    {
        "id": 3,
        "name": "TestCompany",
        "address": "Moscow",
        "phone": "+79250028756",
        "email": "test@mail.com"
    }
]


IDENTITY MAP
[
    {
        "id": 1,
        "name": "TestName",
        "surname": "TestSurname"
    },
    {
        "id": 2,
        "name": "TestName",
        "surname": "TestSurname"
    }
]
```

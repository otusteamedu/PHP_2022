# PHP_2022

## ДЗ: API

### Цель
Научиться создавать универсальный интерфейс для различных потребителей (frontend фреймворки, мобильные приложения, сторонние приложения)  

### Описание/Пошаговая инструкция выполнения домашнего задания
- Необходимо реализовать Rest API с использованием очередей.  
- Ваши клиенты будут отправлять запросы на обработку, а вы будете складывать их в очередь и возвращать номер запроса.  
- В фоновом режиме вы будете обрабатывать запросы, а ваши клиенты периодически, используя номер запроса, будут проверять статус его обработки.  
- Разрешается:  
  - Использование Composer-зависимостей  
  - Использование микрофреймворков (Lumen, Silex и т.п.)  

### Приложение
- приложение выполняет поиск DNS записей (АААА)
- пользователь вводит доменное имя сайта (хост)
- через некоторое время получает АААА записи

### Стэк
- PHP 8.1
- Leaf PHP
- MySQL 8+
- Phinx (для миграций)
- RabbitMQ

### Запуск
- склонировать проект ```https://github.com/otusteamedu/PHP_2022/tree/AShvedov/hw17```
- перейти в диреткорию проекта, из директории проекта в ```/src```
- из директории ```/src``` выполнить последовательно ```cp .env.example .env```, ```docker-compose build```, ```docker-compose -p 'otus-hw17' up -d```
- если все успешно, то будет создано 5 контейнеров  
![img.png](readme-imgs/img.png)  
- теперь нужно зайти в контейнер ```otus-hw17``` и выполнить ```composer install```  
- если все успешно, то в браузере по пути ```http://localhost:8010/``` откроется приветственное окно  
![img_1.png](readme-imgs/img_1.png)  
- затем из этого же контейнера последовательно выполнить ```./vendor/bin/phinx migrate -e development```, ```./vendor/bin/phinx seed:run -e development```
- если все успешно, то открыть phpmyadminer по пути ```http://localhost:9991/``` (сервер: ```db-hw17```, имя пользователя: ```admin```, пароль: ```root```) будет доступна БД:  
![img_2.png](readme-imgs/img_2.png)  
![img_3.png](readme-imgs/img_3.png)  
![img_4.png](readme-imgs/img_4.png)  
![img_5.png](readme-imgs/img_5.png)  
- из этого же контейнера выполнить ```chmod +x amqp_consumer.php```  
- RabbitMQ должен быть доступен по адресу ```http://localhost:15672/``` (username: ```guest```, password: ```guest```)  
![img_6.png](readme-imgs/img_6.png)  
- Документация по API доступна по адресу ```http://localhost:8010/swagger``` (для авторизации - username: ```developer```, password: ```bitnami```)
![img_7.png](readme-imgs/img_7.png)  

### Проверка работы
- Работу приложения можно проверить из документации API - ```http://localhost:8010/swagge```
- Нужно сначала авторизоваться
![img_8.png](readme-imgs/img_8.png)  
![img_9.png](readme-imgs/img_9.png)  
- Затем у ```endpoint``` ```/api/v1/dns-records/{host}``` нажать ```Try it out```
![img_10.png](readme-imgs/img_10.png)  
- ввести любое доменное имя и нажать ```execute```
![img_11.png](readme-imgs/img_11.png)  
- система выдала ```uuid``` апи задачи
![img_12.png](readme-imgs/img_12.png)  
- задача добавилась в очередь
![img_13.png](readme-imgs/img_13.png)  
- проверим выполнение задачи не запуская консьюмер  
![img_14.png](readme-imgs/img_14.png)  
- запустим консьюмер: для этого открыть в новой вкладке терминала контейнер ```otus-hw17``` и выполнить ```./amqp_consumer.php```  
![img_15.png](readme-imgs/img_15.png)  
- проверим результат работы апи задачи  
![img_16.png](readme-imgs/img_16.png)  
# PHP_2022

## Homework 17: Rest API with Queues
________________________________

Создайте файл `.env` из `.env.example`.
Необходимо заполнить некторые поля по примеру:
```
DB_ROOT_PASS=root
DB_DATABASE=hw17
DB_USERNAME=admin
DB_PASSWORD=admin

RABBITMQ_USER=admin
RABBITMQ_PASSWORD=admin
```

Запуск
```
docker-compose build --no-cache
docker-compose up -d
docker exec -it php-app bash
composer install
php artisan key:generate
php artisan migrate

```
Запуск очередей
```
docker exec -it php-app bash
php artisan rabbitmq:consume
```

[Документация к запросам](https://documenter.getpostman.com/view/12114546/2s93CSnATP)

Примечание:  
Установлена искусственная задержка (10 секунд) между статусами "Обрабатывается" и "Обработан"

Так же прикреплена коллекция постмана.

Примечание: в postman используется домен _dev.site_, 
не забудьте добавить его в файл hosts или замените на свой

# Учебное задание OUTUS по теме API

Это учебное API в рамках домашнего задания Otus. Сервис берет целое число и осуществляет проверку на простоту. Задание ставится в очередь и результат доступен по ИД задания. 

В качестве фреймворка исползуется Lumen, база данных для харение результатов - MySQL, сервер очередей - RabbitMQ.

## Установка

Запустить контейнеры, накатить миграции (php artisan migrate), запустить консьюмера (php artisan rabbitmq:consume).

## Работа с API

Интерактивная документация доступна по адресу 127.0.0.1 (или localhost) в зависимости от окружения:

![img.png](img.png)

Отправляем число в очередь на проверку (например, 1073676287 - чтобы было большое время просчета):

![img_1.png](img_1.png)

Здесь мы получили идентификатор задания, по которму проверяем результат. Как видно, простыми алгоритмами проверка осуществляется дополно долго:

![img_2.png](img_2.png)

По окончании высилений мы получим финальный результат - число простое.

### Пример вывода в консоль:

![img_3.png](img_3.png)







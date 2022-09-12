# Инструкция по запуску

Запустить приложение, используя докер.

Так как в контейнере app [php-fpm] для запуска php используется supervisord,
то скрипт для обработки очереди заявок запустится автоматически, однако, его
так же можно запустить, выполнив в консоли команду:

`php /data/application.local/scripts/credit:requests:process.php`

## Application

![Application](images/app.png)

![Console](images/script.png)

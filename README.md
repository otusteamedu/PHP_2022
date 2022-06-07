# PHP_2022

Запуск приложения очереди:

http://otus.local/?message=get-report

Запуск воркера:

php bin/console messenger:consume async


Запуск проверки статуса:

php bin/console app:get-status-message message --id=<ID_QUEQUE> 

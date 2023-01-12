# Инструкция по запуску

Запустить приложение, используя Docker - [README](../README.md).

[Swagger документация по API (openapi v3)](openapi.yaml)

## Application

Запрос всех запросов:
![getAllEnquiries](images/getAllEnquiries.png)

Запрос информации по заявке используя ID:
![getEnquiryId](images/getEnquiryId.png)

Создание нового запроса:
![saveEnquiry](images/saveEnquiry.png)

Ошибка при создании нового запроса:
![saveEnquiryError](images/saveEnquiryError.png)

Для получения сообщения в очереди необходимо запустить скрипт:
1) Заходим контейнер app [php-fpm]
2) docker exec -ti {php_fpm_container} /bin/sh
3) php mysite.local/script/script.php

![api_queue.png](images/api_queue.png)
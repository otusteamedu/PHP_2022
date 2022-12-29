# PHP_2022

### Run app

```
1. add line '127.0.0.1 mysite.local' to your hosts file 
2. Copy file .env.example to .env
3. "cd code && composer install && cd .."
4. "docker compose --env-file .env up --build -d"
```

## Instructions HW15 RabbitMQ
```
Создаем очередь и отправляем в нее сообщение
1. Заполняем поля на mysite.local в формочке и нажимаем "Отправить запрос" 

Запускаем механизм получения сообщения из очереди
2. Заходим в docker контейнер php-fpm docker exec -ti {php_fpn_container} /bin/sh
3. "cd mysite.local/script"
4. "php script.php"

Теперь все новые отправленные заявки будут прилетать в консольном получателе сообщений 
```
1. Добавляем в /etc/hosts application.local
2. Запускаем docker-compose
3. Заходим в контейнер consumer и запускаем
```
cd application.local
php command/index.php
```
3. Добавляем запрос через метод API:
```
POST http://application.local/api/v1/userQuery
```
4. Проверяем статус запроса через метод API:
```
GET http://application.local/api/v1/userQuery/{id}
```
, где {id} - это id запроса, int, полученный при добавлении

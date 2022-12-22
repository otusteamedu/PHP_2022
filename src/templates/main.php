<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Hw11</title>
</head>
<body>
<div>Привет. Это домашняя работа по Redis из курса PHP 2022 Professional</div>
<div>Для работы используйте следующие запросы:</div>
<ul>
    <li><b>users/create</b> - добавить пользователя, тип POST</li>
    <li><b>users/show</b> - получить пользователя по ID, тип GET</li>
    <li><b>users/update</b> - обновить пользователя по ID, тип POST</li>
    <li><b>users/delete</b> - удалить пользователя по ID, тип POST</li>
    <li><b>users</b> - получить список пользователей, тип GET</li>
</ul>
<div>
    Примеры запросов можно найти в коллекции postman, приложенной к этому репозиторию
</div>
<div>
    Патерн IdentityMap использован только для демонстрации реализации,
    в жизни его стоит использовать при потребности неоднократно получать объект или список объектов в рамках
    одного цикла работы php.
</div>
</body>
</html>
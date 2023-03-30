# ДЗ Паттерны работы с данными

### Перед запуском приложения, необходимо переименовать файл **config.ini.example** в **config.ini** и заполнить конфиги подключения к Mysql
    db_host = 
    db_user = 
    db_password = 
    db_name = 
    db_port = 
### Также необходимо заполнить конфиги БД, переименовав .env.example в .env
    MYSQL_ROOT_PASSWORD = 
    MYSQL_DATABASE = 

### Приложение работает как API сервис.
### Endpoint:
#### 1) Добавление полльзователя  
    POST /user/create 
    {
        "email": "test2@test.ru",
        "phone": "2271230935533",
        "age": 45
    }
#### 2) Получение всех пользователей
    GET /user/getAll

#### 3) Получение пользователя по ID
    GET /user/getOne?id=1

#### 4) Обновление пользователя
    PUT /user/update
    {
        "email": "test2@test.ru",
        "phone": "2271230935533",
        "age": 45
    }
#### 5) Удаление пользователя
    DELETE /user/delete?id=1
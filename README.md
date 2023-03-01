# ДЗ Работ с Redis

### Перед запуском приложения, необходимо переименовать файл **config.ini.example** в **config.ini** и заполнить путь до Redis
    redis_host = http://path/to/redis

### Приложение работает как API сервис.
### Endpoint:
#### 1) Добавление события  
    POST /event/add 
    {
        "priority": 9999,
        "conditions": "param1=1",
        "event": "flush33"
    }
#### 2) Получение всех событий
    GET /event/getAll

#### 3) Получение события по параметрам, с самым высоким приоритетом
    GET /event/getOne?param1=1&param2=5

#### 4) Очистка всех событий
    DELETE /event/clear
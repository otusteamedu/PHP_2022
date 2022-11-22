# PHP_2022

## Instructions (HW11 Redis)

### Run app

```
1. add line '127.0.0.1 mysite.local' to your hosts file 
2. Copy file .env.example to .env
3. "cd code && composer install && cd .."
4. "docker compose --env-file .env up --build -d"
```

### Usage example

```
ADD events:
- http://mysite.local/add-event/{"priority":1000,"conditions":{"param1":1},"event": "event1"}
- http://mysite.local/add-event/{"priority":2000,"conditions":{"param1":2,"param2":2},"event": "event2"}
- http://mysite.local/add-event/{"priority":3000,"conditions":{"param1":1,"param2":2},"event": "event3"}

GET related event:
- http://mysite.local/get-event/{"params":{"param1":1,"param2":2}}

REMOVE all events:
- http://mysite.local/delete-events/
```


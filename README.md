# PHP_2022

## Instructions (HW11 Redis)

### Checkout GIT project
```
git clone https://github.com/otusteamedu/PHP_2022.git
git checkout KDmitrienko/hw11
```

### Run app

```
1. Copy file example.env to .env
2. "cd code && composer install && cd .."
3. "docker-compose up -d"
4. add line '127.0.0.1 mysite.local' to your hosts file
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

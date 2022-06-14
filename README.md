# PHP_2022: Event system

## Launch

```bash
$ git clone git@github.com:otusteamedu/PHP_2022.git -b f_belousov/hw_13 f_belousov/hw_13
$ cd f_belousov_hw_13
$ cp .env.example .env
$ cp frontend/.env.example frontend/.env
$ cp backend/.env.example backend/.env
$ docker-compose build
$ docker-compose up -d
$ npm install -g @vue/cli
$ cd frontend 
$ npm run serve 
```

## REDIS

### Last id

````
data type: string
---------
key: event_last_id
---------
value: 1
 
````

### Event

````
data type: hash
---------
key: event:1
---------
value: 
{
    "id": "1"
    "priority": "1000"
    "name": ""test_1"
    "params": "[{\"name\":\"param1\",\"value\":\"1\"}]"
} 
````



### Param

````
data type: set
---------
key: event_param:{name}:{value}
---------
value: 1,2,3,4,5,6
 
````

## API

### Find event by params 
```
http://0.0.0.0:85/api/v1/search/event?{...$params}
```
example
```
http://0.0.0.0:85/api/v1/search/event?param1=1
```



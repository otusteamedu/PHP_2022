# PHP_2022

#### Requirements
- Docker

#### Usage
- из корня проекта выполнить ```docker-compose build```, затем ```docker-compose -p 'otus-hw6' up -d```
- создадутся два контейнера:
![img.png](readme-img/img.png)
- сервер запускать из ```app-server-hw6```, клиента соответственно из ```app-client-hw6```
- команды на запуск:
  - ```php app.php server```
  - ```php app.php client``` соответственно
![img.png](readme-img/img_1.png)
![img_1.png](readme-img/img_2.png)
- команды на останов:
  - остановить только клиента - ```stop``` (сервер остается работать)
  - остановить клиента и сервер - ```close:connection```
![img_5.png](readme-img/img_5.png)
![img_6.png](readme-img/img_6.png)
![img_7.png](readme-img/img_7.png)

#### Пример работы
![img_3.png](readme-img/img_3.png)
![img_4.png](readme-img/img_4.png)


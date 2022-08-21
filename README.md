# PHP_2022
## Homework №4
1. Запустить из корня проекта ```docker-compose build```
2. Как будет собран образ, запустить ```docker-compose -p 'otus-hw4' up -d```
3. В файл ```hosts``` добавить: ```127.0.0.1 ashvedov.local```
4. Зайти в любой из контейнеров ```app-fpm1```, ```app-fpm2```, ```app-fpm3``` и выполнить ```composer install```
5. Если все успешно, то по адресу ```http://ashvedov.local:8005``` откроется сайт

- сайт открывается
![img.png](reports/img.png)

- nginx-контейнеры
![img_7.png](reports/img_7.png)
![img_1.png](reports/img_1.png)
![img_2.png](reports/img_2.png)
![img_3.png](reports/img_3.png)

- демонстрация работы nginx балансера:
![img_4.png](reports/img_4.png)
![img_5.png](reports/img_5.png)
![img_6.png](reports/img_6.png)

- демонстрация работы валидатора
![img_8.png](reports/img_8.png)
![img_9.png](reports/img_9.png)
![img_10.png](reports/img_10.png)
![img_11.png](reports/img_11.png)
![img_12.png](reports/img_12.png)
![img_13.png](reports/img_13.png)
![img_14.png](reports/img_14.png)

- демонстрация работы кластера memcached (объединены в кластер при помощи ```mcrouter```)
![img_16.png](reports/img_16.png)
![img_17.png](reports/img_17.png)
![img_18.png](reports/img_18.png)
![img_19.png](reports/img_19.png)
![img_20.png](reports/img_20.png)
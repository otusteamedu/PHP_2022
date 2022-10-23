# PHP_2022  

# ДЗ: Redis  

### Установка
- создать файл ```.env``` и скопировать в него все из ```env.local```
- из директории куда скачаны исходники выполнить ```docker-compose build```
- как сборка завершится, выполнить ```docker-compose up -d```
- если все успешно, то будут созданы три контейнера:  
![img.png](readme_img/docker.png)  
- убедиться что ```redis``` работает, можно зайдя в контейнер ```redis-hw11``` и там выполнить ```redis-cli```:  
![img_1.png](readme_img/redis.png)  
- убедиться что работает ```memcached``` можнт зайди в контейнер ```otus-hw11``` и выполнить ```telnet memcached 11211```:   
![img.png](readme_img/memcached.png)  
- убедиться, что работает ```nginx можно```, открыв в браузере адрес ```http://localhost:8005```:
![img.png](readme_img/nginx.png)  

### Настройка
- зайдя в контейнер ```otus-hw11``` выполнить ```chmod +x analytics_panel.php```
- Доступна работа с двумя NoSQL БД - ```Memcached``` и ```Redis```. Переключение осуществляется путем изменения значения параметра ```repository``` в конфиг. файле ```app\src\config\common.php```  

### Взаимодействие с системой  
- Работа с системой возможна через ```HTTP API``` и ```Cli API```
- Для работы через командную строку нужно зайти в контейнер ```otus-hw11``` и выполнить ```./analytics_panel.php```. Дальше просто выбирать пункты пределагаемые системой  
- Для работы через ```HTTP API``` предусмотрены следующие ```url```:
- ```/api/event/add``` - добавление события: ```{"key":"event", "score":1000, "conditions":"param=1,param=2", "event_description":"event1"}```  
- ```/api/event/get``` - получения конкретного события: ```{"key":"event", "conditions":"param=1,param=2", "event_description":"event1"}```  
- ```/api/event/get_all``` - получения всех добавленных событий: ```{"key":"event"}```  
- ```/api/event/delete``` - удаление конкретного события: ```{"key":"event", "conditions":"param=1,param=2", "event_description":"event1"}```  
- ```/api/event/delete_all``` - удаление всех событий: ```{"key":"event"}```  
- Все запросы и ответы от ```HTTP API``` в ```JSON```
- Результатом поиска и удаления всегда будет событие соответствуюшие заданным условиям поиска, но с максимальным рангом (```score```)  


### Примеры работы через консольное приложение
- Начало:  
![img.png](readme_img/img.png)  
- Событий нет:  
![img_1.png](readme_img/img_1.png)  
- Начинаем добавлять:  
![img_2.png](readme_img/img_2.png)  
- Продолжаем:  
![img_3.png](readme_img/img_3.png),  
![img_4.png](readme_img/img_4.png)  
- Проверяем что события добавлены:  
![img_5.png](readme_img/img_5.png)  
- Получаем событие:  
![img_6.png](readme_img/img_6.png)   
![img_7.png](readme_img/img_7.png)  
- Удалим второе событие:  
![img_8.png](readme_img/img_8.png)  
- Удалим все события:  
![img_9.png](readme_img/img_9.png)  

### Примеры работы через HTTP API  
- Переключимся на Memcached (проверим через консольное приложение):  
![img_10.png](readme_img/img_10.png)  
- Проверием что событий нет:  
![img_11.png](readme_img/img_11.png)  
- Начинаем добавлять:  
![img_12.png](readme_img/img_12.png)  
- Продолжаем:  
![img_13.png](readme_img/img_13.png)  
![img_14.png](readme_img/img_14.png)  
- Проверяем что события добавлены:  
![img_15.png](readme_img/img_15.png)  
- Получаем событие:  
![img_16.png](readme_img/img_16.png)  
- Получаем другое событие:  
![img_17.png](readme_img/img_17.png)  
- Удаляем второе событие:  
![img_18.png](readme_img/img_18.png)  
- Проверяем:  
![img_19.png](readme_img/img_19.png)  
- Удалим все события:  
![img_20.png](readme_img/img_20.png)  
- Проверяем:  
![img_21.png](readme_img/img_21.png)  

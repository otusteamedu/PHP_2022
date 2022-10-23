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

### Использование
- зайдя в контейнер ```otus-hw11``` выполнить ```chmod +x analytics_panel.php```
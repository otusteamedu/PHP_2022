# PHP_2022
https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

### Homework #3

В данной домашней работе подключен и используется пакет осуществляющий преобразование многомерных (вложенных) 
нумерованных (не ассоциативных) массивов в простой нумерованный массив без вложенности.  
Пакет подключается командой:
```
composer require ashvedov/array-flatten
```
Также имется возможность запустить данную домашнюю работу в докере.  
Из корня проекта выполнить:
1.
```
docker-compose build
```
2.
```
docker-compose -p 'ashvedov-homework3' up -d
```
3. Если контейнеры запустились, то в терминале зайти в контейнер приложения:
```
docker exec -it app /bin/sh
```
4. В контейнере выполнить:
```
composer install
```
5. Открыть в браузере
```
http://localhost:8005/
```
6. Пакет подключен и выполняется из:
```
src/index.php
```

# PHP_2022
## ДЗ: Проектирование БД

- Из корня проекта выполнить - ```docker-compose -p 'otus-hw7' up -d```
- Должны создасться и стартануть два контейнера:
![img.png](summary/img.png)
  (pgadmin добавлен для удобства - открывается по адресу: ```http://localhost:5050/browser/```)
- База инициализируется автоматически файлами:
  - ```Otus-hw7_postgres_create.sql``` - создание таблиц
  - ```test_data.sql``` - тестовые данные (заполение БД)

В самый первый запуск, в pgadmin нужно создать сервер:  
![img.png](summary/img_8.png)  
Задать имя:  
![img_1.png](summary/img_9.png)  
В host указать имя контейнера БД (не контейнера pgadmin!):  
![img_2.png](summary/img_10.png)  
Если данных в таблиц нет, то выбрать БД, вызвать query tool:  
![img_3.png](summary/img_11.png)  
затем скопировать все из файла ```test_data.sql``` и вставить в окно SQL запросов pgadmin.

Если все ок, то БД готова:  
![img_1.png](summary/img_1.png)

UML диаграмма БД (есть так же в pdf - директория summary):  
![otus-hw7-uml.png](summary/otus-hw7-uml.png)

Вывод сеансов фильмов и цен за сеанс и за фильм:  
![img_2.png](summary/img_2.png)

Прибыль по всем фильмам, начиная с самого прибыльного:
![img.png](summary/img_12.png)

Самый прибыльный фильм:  
![img_3.png](summary/img_3.png)

Меняем данные, имитируя что на "Мстителей" пошло не три, а четыре человека:
- было 3:  
![img_4.png](summary/img_4.png)
- стало 4:  
![img_5.png](summary/img_5.png)

Теперь фильм "Мстители" принес 1525 едениц денег:  
![img_6.png](summary/img_6.png)

# PHP_2022
## ДЗ: Проектирование БД

- Из корня проекта выполнить - ```docker-compose -p 'otus-hw7' up -d```
- Должны создасться и стартануть два контейнера:
![img.png](summary/img.png)
  (pgadmin добавлен для удобства - открывается по адресу: ```http://localhost:5050/browser/```)
- База инициализируется автоматически файлами:
  - ```Otus-hw7_postgres_create.sql``` - создание таблиц
  - ```test_data.sql``` - тестовые данные (заполение БД)
Если все ок, то БД готова:  
![img_1.png](summary/img_1.png)

UML диаграмма БД (есть так же в pdf - директория summary):  
![otus-hw7-uml.png](summary/otus-hw7-uml.png)

Вывод расписания:  
![img_2.png](summary/img_2.png)

Самый прибыльнй фильм:  
![img_3.png](summary/img_3.png)

Меняем данные, имитируя что на "Человека-паука" пошло не три, а четыре человека:
- было 3:  
![img_4.png](summary/img_4.png)
- стало 4:  
![img_5.png](summary/img_5.png)

Теперь фильм "Человек-паук" принес 1000 единц денег:  
![img_6.png](summary/img_6.png)

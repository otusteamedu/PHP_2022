# PHP_2022

# ДЗ: Паттерны работы с данными

## Установка
- создать файл ```.env``` и скопировать в него все из ```env.example```
- из директории куда скачаны исходники выполнить ```docker-compose build```
- как сборка завершится, выполнить ```docker-compose -p 'otus-hw12' up -d```
- если все успешно, то буду созданы 3 контейнера:  
![img.png](readme_imgs/img.png)  
- также, нужно зайти в контейнер ```app-hw12``` и выполнить ```chmod +x start_search.php```

## Что сделано
- Был реализован паттерн ```Data Mapper```  
- Реализован метод получения всех записей таблицы  
- Реализован дополнительный паттерн ```Identity Map```  
- База данных postgres. Структура и данные взяты из ```ДЗ №8```  
- Инициализация БД подробно описана в ```ДЗ №8``` и ```№7```  
  ![img.png](readme_imgs/img_1.png)  
  ![img_2.png](readme_imgs/img_2.png)  
  ![img_2.png](readme_imgs/img_3.png)  
- За основу работы для текущего ДЗ взята таблица ```ticket```   
  ![img.png](readme_imgs/img_4.png)  

## Пример работы  
- Поиск конкретного билета:  
![img_1.png](readme_imgs/img_5.png)  
- Получение всех билетов:  
![img_2.png](readme_imgs/img_6.png)  
- Добавление нового билета:  
![img_3.png](readme_imgs/img_7.png)  
![img_4.png](readme_imgs/img_8.png)  
- Обновление билета:  
![img_5.png](readme_imgs/img_9.png)  
![img_6.png](readme_imgs/img_10.png)  
- Удаление конкретного билета:  
![img_7.png](readme_imgs/img_11.png)  
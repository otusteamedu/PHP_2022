# Дмитрий Козлов HW 16

# 1. Запуск контейнера
```
docker-compose up -d --build
```
# 2. Установка зависимостей
```
docker exec otus_web composer install
```
# 3. Запуск консьюмера
```
docker exec -it otus_consumer /bin/bash
cd public
php index.php --command=bank-statement-consumer
```
# 4. Отправка формы происходит со страницы
```
http://application.local/
```
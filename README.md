# Дмитрий Козлов HW 16

# 1. Запуск контейнера
```
docker-compose up -d --build
```
# 2. Установка зависимостей
```
docker exec otus_web composer install
```
# 3. Запуск консьюмеров
```
docker exec otus_create_consumer bash -c "cd public && php index.php --command=create-operation-consumer"
docker exec otus_find_consumer bash -c "cd public && php index.php --command=find-operation-consumer"
docker exec otus_remove_consumer bash -c "cd public && php index.php --command=remove-operation-consumer"
```
# 4. Документация
```
http://application.local:8080/
```

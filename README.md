# PHP_2022 Домашнее задание HW4 и HW5

# Перед тем, как запускать docker-compose установите зависимости!
```
cd code
docker run --rm --interactive --tty --volume ${PWD}:/app composer install
```

# В hosts добавить
```
127.0.0.1   otus.mvc
```

# Запуск
```
cd code
docker compose --env-file ./config/.env up
```
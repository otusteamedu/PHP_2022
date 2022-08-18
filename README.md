# PHP_2022 Домашняя работа №6

Реализован класс-валидатор EmailValidator()

## Применение:

```php
$email = 'my_email@yandex.ru';
$validator = new EmailValidator();
if (!$validator->validate($email)) {
    echo $validator->getError(); // вывод ошибки, в случае когда email не валиден
}
// Дальнейшая обработка - отправка письма или сохранение в бд
```
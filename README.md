# Проверка Email
Проверяет Email на корректность, опционально по MX записи
## Требования
- PHP 7.1
## Установка
 ```bash
 $ composer require ppro/hw4
 ```

## Использование
```php
<?php
//файл
$emailValidator = new Ppro\Hw4\Email\Validator('/path_to_file/file.txt');
var_dump($emailValidator->validate());

//строка
$emailValidator = new Ppro\Hw4\Email\Validator();
echo $emailValidator->validateEmail('test@ya.ru');
```
 
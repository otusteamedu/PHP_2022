# Процессор строк

 Преобразование каждого слова строки к верхнему регистру
 
## Требования

- PHP 7.4

## Установка

~~~bash
$ composer require olehandrei/my-composer-lib
~~~

## Использование

~~~php
<?php
$new_app = new StringModify();
echo $new_app->convertString('наШа мАша громкО плаЧет');
~~~
<?php

declare(strict_types=1);

require_once "./vendor/autoload.php";

use Maldoshina\StringValidator\Validator;

echo "Привет, Otus!<br>" . date("Y-m-d H:i:s") . "<br><br>";

echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'] . "<br><br>";

$string         = $_POST['string'];
$validateResult = (new Validator())->validateBrackets($string);

if ($validateResult) {
    http_response_code(200);
    echo "Строка " . $string . " валидна";
} else {
    http_response_code(400);
    echo "Строка " . $string . " не валидна";
}
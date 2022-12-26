<?php

declare(strict_types=1);

require_once "./vendor/autoload.php";

use Maldoshina\StringValidator\Validator;

try {
    echo (new Validator())->validateBrackets($_POST['string']);
} catch (Exception $e) {
    http_response_code($e->getCode());
    echo $e->getMessage();
}

echo "<br><br>Привет, Otus!<br>" . date("Y-m-d H:i:s");
echo "<br><br>Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];

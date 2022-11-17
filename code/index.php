<?php

require __DIR__.'/vendor/autoload.php';

use Study\StringValidator\Service\StringValidatorService;
use Study\StringValidator\App;
$se = new StringValidatorService();
$app = new App($se);


if (isset($_POST['string'])){

    if ($app->run($_POST['string'])){
        echo "Строка корректа";
        http_response_code(200);
    } else {
        echo "Строка некорректа.";
        http_response_code(400);

    }
}

echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
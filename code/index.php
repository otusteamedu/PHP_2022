<?php

require __DIR__.'/vendor/autoload.php';


use Study\StringValidator\App;

$app = new App();
$app->run();




//echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
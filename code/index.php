<?php

require __DIR__.'/vendor/autoload.php';


use Study\StringValidator\App;
use Albinamkh\MonthTranslator\MonthTranslator;

$app = new App();
$app->run();

$mt = new MonthTranslator();

echo $mt->translate(9);



//echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
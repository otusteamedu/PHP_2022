<?php

declare(strict_types=1);

session_start();

include('../vendor/autoload.php');

use Ekaterina\Hw4\App\App;

echo date('d.m.Y H:i:s') . '<br>';
echo 'Сервер:  '. $_SERVER['HOSTNAME'] . '<br>';
echo 'ID сессии: ' . session_id() . '<br>';

$app = new App();
$app->run();
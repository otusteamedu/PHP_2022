<?php

declare(strict_types=1);

use Eliasjump\StringsVerification\Application;
use Eliasjump\StringsVerification\Controllers\StringController;

require __DIR__ . '/vendor/autoload.php';

session_start();
!isset($_SESSION['counter']) ? $_SESSION['counter'] = 1 : $_SESSION['counter']++;

$app = new Application();

$app->router->get('/', function () {
    $text = [];

    $text[] = 'ID сессии: ' . session_id();
    $text[] = "Счетчик посещений: " . $_SESSION['counter'];
    $text[] = "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];

    return implode("<br/>", $text);
});

$app->router->post('/', [StringController::class, 'run']);

$app->run();

<?php

declare(strict_types=1);

use Eliasjump\StringsVerification\Application;
use Eliasjump\StringsVerification\Controllers\MainPageController;
use Eliasjump\StringsVerification\Controllers\StringController;

require __DIR__ . '/../vendor/autoload.php';

session_start();
!isset($_SESSION['counter']) ? $_SESSION['counter'] = 1 : $_SESSION['counter']++;

$app = new Application();

$app->router->get('/', [MainPageController::class, 'run']);

$app->router->post('/', [StringController::class, 'run']);

$app->run();

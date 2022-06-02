<?php
declare(strict_types=1);

use Klein\Klein;

require __DIR__ . '/src/bootstrap/bootstrap.php';

$router = new Klein();

$web = require(__DIR__ . '/src/Routes/web.php');

foreach ($web as $route) {
    $router->respond(...$route);
}

$router->dispatch();

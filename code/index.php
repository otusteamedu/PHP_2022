<?php
declare(strict_types=1);

use Dotenv\Dotenv;
use Klein\Klein;

require __DIR__ . '/src/bootstrap/bootstrap.php';

$router = new Klein();

$api = require(__DIR__ . '/src/Routes/api.php');

foreach ($api as $route) {
    $router->respond(...$route);
}

$router->dispatch();

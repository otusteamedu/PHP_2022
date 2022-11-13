<?php

declare(strict_types=1);

use Eliasjump\StringsVerification\Application;
use Eliasjump\StringsVerification\Controllers\StringController;

require __DIR__.'/vendor/autoload.php';

$app = new Application();

$app->router->get('/', function () {
    return 'Success';
});

$app->router->post('/', [StringController::class, 'run']);

$app->run();

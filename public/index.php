<?php

require(__DIR__) . '/vendor/autoload.php';

use App\HTTP\HTTPController;
use Slim\Factory\AppFactory;

try {
    $app = AppFactory::create();
    $app->addErrorMiddleware(true, true, true);
    $app->post('/', [HTTPController::class, 'checkBracesNum']);
    $app->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}


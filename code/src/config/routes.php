<?php

use Slim\Factory\AppFactory;
use Nikcrazy37\Hw20\Infrastructure\Controller\RequestController;
use Slim\Routing\RouteCollectorProxy;
use Nikcrazy37\Hw20\Libs\Core\DI\DIContainer;

$container = DIContainer::build();
AppFactory::setContainer($container);
$app = AppFactory::create();

$app->group('/api/v1', function (RouteCollectorProxy $group) {
    $group->post('/request', RequestController::class . ':send');
    $group->get('/request/{uid}', RequestController::class . ':check');
});

$app->run();
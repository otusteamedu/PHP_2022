<?php

declare(strict_types=1);
use Mapaxa\BalancerApp\Router;

require_once __DIR__ . '/vendor/autoload.php';

$router = new Router();
$router->run();
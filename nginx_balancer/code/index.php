<?php

declare(strict_types=1);
use Mapaxa\BalancerApp\Router;

define('ROOT', dirname(__FILE__));
require_once __DIR__ . '/vendor/autoload.php';
#файлы системы

require_once (ROOT.'/src/Router.php');

#вызов роутера
$router = new Router();
$router->run();

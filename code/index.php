<?php

declare(strict_types=1);
define('ROOT', dirname(__FILE__));

use Nikcrazy37\Hw4\Router;

require __DIR__ . "/vendor/autoload.php";

$router = new Router();
$router->run();

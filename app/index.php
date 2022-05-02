<?php

declare(strict_types=1);

use Mselyatin\Project6\src\classes\Application;
use Mselyatin\Project6\src\classes\JSONResponse;

require("../vendor/autoload.php");

$routes = include('config/routes.php');
$routeManager = new \Mselyatin\Project6\src\classes\RouteManager($routes);
$response = new JSONResponse();
$config = [];

$app = Application::create($config, $routeManager, $response);
$app->run();


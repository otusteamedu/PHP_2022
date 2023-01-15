<?php
/***
 * @var $router \Otus\Task11\Core\Routing\RouterManager
 */

$router->get('/', [\Otus\Task11\App\Controllers\HomeController::class, 'index']);

<?php
/***
 * @var $router RouterManager
 */

use Otus\Task13\Core\Routing\RouterManager;
use Otus\Task13\Product\Infrastructure\Http;

$router->get('/product/create', Http\Product\CreateProductController::class);
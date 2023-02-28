<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Modules\Queries\Infrastructure\QueryController;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => '/api/v1', 'middleware' => 'api'], function () use ($router) {
    $controllerClass = QueryController::class;
    $router->post('/queries/create', "{$controllerClass}@create");
    $router->get('/queries/{id}', "{$controllerClass}@show");
});

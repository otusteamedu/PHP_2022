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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/api/v1/user', 'UserController@addUser');
$router->get('/api/v1/user/{id}', 'UserController@getUser');
$router->get('/api/v1/users', 'UserController@getUsers');
$router->get('/api/v1/result/{requestId}', 'ResultController@getResult');

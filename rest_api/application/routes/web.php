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

$router->post('/api/v1/addUser', 'UserController@addUser');
$router->get('/api/v1/getUser', 'UserController@getUser');
$router->get('/api/v1/getUsers', 'UserController@getUsers');
$router->get('/api/v1/getResult', 'ResultController@getResult');

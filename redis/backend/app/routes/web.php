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

$router->get('/', 'ApiController@root');
$router->post('/api/v1/add', 'ApiController@add');
$router->post('/api/v1/find', 'ApiController@find');
$router->get('/api/v1/clear', 'ApiController@clear');

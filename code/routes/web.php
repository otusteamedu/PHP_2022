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

$router->get('/', function () use ($router) { return $router->app->version(); });

// отчеты
$router->group(['prefix' => 'report'], function () use ($router) {
    // todo POST запрос на начало работы отчета - отправка в очередь кролика задачи, в БД сохраняем данные, в кролик id из БД - uuid!
    //      отдаем id задачи
    $router->post('', 'ReportCreateController@store');

    // todo отдаем статус задачи и ее состояние из БД
//    $router->get('status/{id}', 'ReportStatusController@status');

    // todo выводим данные отчета
//    $router->get('{id}', 'ReportShowController@show');
});

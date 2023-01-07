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

use App\Modules\Restaurant\Infrastructure\Controllers\RestaurantController;
use Illuminate\Http\Request;

$router->get('/', [
    'as' => 'index',
    fn() => app(RestaurantController::class)->index()
]);
$router->get('/hotdog', [
    'as' => 'hotdog',
    fn(Request $request) => app(RestaurantController::class)->getHotDog($request)
]);

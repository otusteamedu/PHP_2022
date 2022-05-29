<?php

return [
    [
        'path' => '/',
        'method' => 'GET',
        'controller' => 'App\Controllers\IndexController::index'
    ],
    [
        'path' => '/getAnswer',
        'method' => 'POST',
        'controller' => 'App\Controllers\UserController::showAllUsers'
    ],

];
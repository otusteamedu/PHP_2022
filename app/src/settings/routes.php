<?php

return [
    [
        'path' => '/',
        'method' => 'GET',
        'controller' => 'Katya\App\Controllers\IndexController::index'
    ],
    [
        'path' => '/getAnswer',
        'method' => 'POST',
        'controller' => 'Katya\App\Controllers\UserController::getAnswer'
    ],

];
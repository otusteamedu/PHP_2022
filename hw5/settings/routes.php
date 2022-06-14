<?php

return [
    [
        'path' => '/',
        'method' => 'GET',
        'controller' => 'Katya\hw5\Controllers\IndexController::index'
    ],
    [
        'path' => '/result',
        'method' => 'POST',
        'controller' => 'Katya\hw5\Controllers\UserController::getEmailResult'
    ],

];
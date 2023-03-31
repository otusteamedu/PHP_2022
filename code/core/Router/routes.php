<?php

$routes = [
    '/user/getAll' => [
        'class_name' => 'App\User\Infrastructure\Http\GetController', 
        'method' => 'getAll'
    ],
    '/user/getOne' => [
        'class_name' => 'App\User\Infrastructure\Http\GetController', 
        'method' => 'getOne'
    ],
    '/user/create' => [
        'class_name' => 'App\User\Infrastructure\Http\CreateController', 
        'method' => 'create'
    ],
    '/user/update' => [
        'class_name' => 'App\User\Infrastructure\Http\UpdateController', 
        'method' => 'update'
    ],
    '/user/delete' => [
        'class_name' => 'App\User\Infrastructure\Http\DeleteController', 
        'method' => 'delete'
    ],
];
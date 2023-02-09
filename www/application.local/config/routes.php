<?php

$apiPathPrefix = '/api/v1';
$controllerNamespace = 'app\controllers\\';

return [
    [
        'path' => $apiPathPrefix.'/userQuery',
        'method' => 'post',
        'controller' => $controllerNamespace.'UserQueryController',
        'controllerMethod' => 'create'
    ],
    [
        'path' => $apiPathPrefix.'/userQuery/{id}',
        'method' => 'get',
        'controller' => $controllerNamespace.'UserQueryController',
        'controllerMethod' => 'view'
    ]
];

<?php

return [
    'routes' => [
//        'class' => \Mselyatin\Project6\src\classes\RouteManager::class,
        'rules' => [
            [
                'path' => '/',
                'class' => \Mselyatin\Project6\src\controllers\IndexController::class,
                'method' => 'index',
                'slag_route' => 'index_route'
            ],
            [
                'path' => '/valid/email',
                'class' => \Mselyatin\Project6\src\controllers\ValidatorController::class,
                'method' => 'emailValidation',
                'slag_route' => 'emailValidation_route'
            ]
        ]
    ]
];
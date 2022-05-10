<?php

use App\Ddd\Infrastructure\Http\EventController;

return [
    [
        'url' => '/event/add',
        'controller' => EventController::class,
        'action' => 'add',
    ],
    [
        'url' => '/event/delete',
        'controller' => EventController::class,
        'action' => 'delete',
    ],
    [
        'url' => '/event/get',
        'controller' => EventController::class,
        'action' => 'get',
    ],
];

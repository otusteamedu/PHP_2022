<?php

use Patterns\App\Infrastructure\Http\AtmController;

return [
    [
        'url' => '/atm/put',
        'controller' => AtmController::class,
        'action' => 'put',
    ],
    [
        'url' => '/atm/give',
        'controller' => AtmController::class,
        'action' => 'give',
    ],
];

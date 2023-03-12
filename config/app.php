<?php

return [
    'middleware' => [
        \App\Application\Middleware\ValidateStringFieldMiddleware::class,
        \App\Application\Middleware\ValidateEmailFieldMiddleware::class,
        \App\Application\Middleware\TestServicesMiddleware::class,
    ],
];
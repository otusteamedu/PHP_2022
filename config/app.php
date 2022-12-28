<?php

return [
    'middleware' => [
        \App\App\Middleware\ValidateStringFieldMiddleware::class,
        \App\App\Middleware\ValidateEmailFieldMiddleware::class,
        \App\App\Middleware\TestServicesMiddleware::class,
    ],
];
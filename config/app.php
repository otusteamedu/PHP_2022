<?php

return [
    'middleware' => [
        \App\App\Middleware\ValidateStringFieldMiddleware::class,
        \App\App\Middleware\TestServicesMiddleware::class,
    ],
];
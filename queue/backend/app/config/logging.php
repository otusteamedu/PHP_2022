<?php

use Monolog\Handler\StreamHandler;

return [
    'default' => env('LOG_CHANNEL', 'stack'),
    'deprecations' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['stderr'],
            'ignore_exceptions' => false
        ],
        'stderr' => [
            'driver' => 'monolog',
            'level' => 'error',
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],
    ]
];

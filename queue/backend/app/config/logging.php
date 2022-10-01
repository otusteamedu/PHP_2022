<?php

use Monolog\Handler\StreamHandler;

return [
    'default' => env('LOG_CHANNEL', 'stack'),
    'deprecations' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['stderr', 'debug'],
            'ignore_exceptions' => false
        ],
        'debug' => [
            'driver' => 'monolog',
            'level' => 'debug',
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
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

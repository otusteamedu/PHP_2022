<?php

/**
 * App configuration properties
 */
return [
    'redis' => [
        'host' => $_ENV['REDIS_HOST'],
        'port' => $_ENV['REDIS_PORT'],
        'pass' => $_ENV['REDIS_PASSWORD'],
    ]
];

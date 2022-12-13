<?php

return [
    'repository' => [
        //'storage' => 'redis',
        'storage' => 'memcached',
        'redis_host' => $_ENV['REDIS_HOST'],
        'redis_port' => $_ENV['REDIS_PORT'],
        'redis_pass' => $_ENV['REDIS_PASSWORD'],
        'memcached_host' => $_ENV['MEMCACHED_HOST'],
        'memcached_port' => $_ENV['MEMCACHED_PORT'],
    ]
];

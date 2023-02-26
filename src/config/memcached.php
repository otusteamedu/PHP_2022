<?php

declare(strict_types=1);

return [
    'memcached' => [
        'host' => getenv('MEMCACHED_HOST'),
        'port' => getenv('MEMCACHED_PORT'),
    ],
];
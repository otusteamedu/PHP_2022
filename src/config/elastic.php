<?php

declare(strict_types=1);

return [
    'elastic' => [
        'host' => getenv('ELASTIC_HOST'),
        'user' => getenv('ELASTIC_USER'),
        'password' => getenv('ELASTIC_PASS'),
        'certPath' => getenv('ELASTIC_CERT_PATH'),
    ],
];
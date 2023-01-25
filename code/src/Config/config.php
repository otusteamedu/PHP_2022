<?php

/**
 * Rabbit config
 */

return [
    'repository'    => [
        'hostname'  => $_ENV['RABBITMQ_HOSTNAME'],
        'port'      => $_ENV['RABBITMQ_PORT1'],
        'user'      => $_ENV['RABBITMQ_USER'],
        'password'  => $_ENV['RABBITMQ_PASSWORD']
    ]
];

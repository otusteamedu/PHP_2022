<?php

use Mselyatin\Queue\infrastructure\queue\RabbitQueue;

return [
    'class' => RabbitQueue::class,
    'host' => '172.20.0.4',
    'port' => 5672,
    'user' => 'user',
    'password' => 'user',
    'vhost' => '/',
    'connection_timeout' => 60.0,
    'connection_write' => 60.0
];
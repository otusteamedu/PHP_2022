<?php

use App\Application\Chat\Client;
use App\Application\Chat\Server;
use App\Infrastructure\Logger\ConsoleLogger;
use Psr\Container\ContainerInterface;

return [
    'chat.server_socket' => BASE_PATH."/socket/server.sock",
    'chat.client_socket' => BASE_PATH."/socket/client.sock",

    'LoggerInterface' => DI\create(ConsoleLogger::class),

    'chat.server' => DI\factory(function (ContainerInterface $c, $logger) {
        return new Server($c->get('chat.server_socket'), $logger);
    })->parameter('logger', DI\get('LoggerInterface')),

    'chat.client' => DI\factory(function (ContainerInterface $c, $logger) {
        return new Client($c->get('chat.client_socket'), $c->get('chat.server_socket'), $logger);
    })->parameter('logger', DI\get('LoggerInterface')),
];
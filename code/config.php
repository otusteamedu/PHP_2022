<?php

use App\Application\Command\AppClientCommand;
use App\Application\Command\AppServerCommand;
use App\Infrastructure\Logger\ConsoleLogger;
use App\Infrastructure\Socket\ClientSocketWorker;
use App\Infrastructure\Socket\ServerSocketWorker;

return [
    'chat.server_socket' => BASE_PATH."/socket/server.sock",
    'chat.client_socket' => BASE_PATH."/socket/client.sock",

    'LoggerInterface' => DI\create(ConsoleLogger::class),
    'ServerChatInterface' => DI\create(ServerSocketWorker::class)->constructor(
        DI\get('chat.server_socket'),
        DI\get('LoggerInterface')
    ),
    'ClientChatInterface' => DI\create(ClientSocketWorker::class)->constructor(
        DI\get('chat.client_socket'),
        DI\get('chat.server_socket'),
        DI\get('LoggerInterface')
    ),

    'chat.server' => DI\create(AppServerCommand::class)->constructor(DI\get('ServerChatInterface')),
    'chat.client' => DI\create(AppClientCommand::class)->constructor(DI\get('ClientChatInterface')),
];
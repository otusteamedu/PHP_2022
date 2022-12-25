<?php

return [
    'path_app' => __DIR__,
    'path_to_email' => __DIR__ . '/../data/emails.txt',
    'path_view' => __DIR__ . '/../views',
    'socket' => __DIR__ . '/../socket',
    'commands' => [
        'server' => \Otus\Task06\App\Commands\StartServerChatCommand::class,
        'client' => \Otus\Task06\App\Commands\StartClientChatCommand::class
    ],
];
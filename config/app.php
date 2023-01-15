<?php

return [
    'path_app' => __DIR__,
    'path_view' => __DIR__ . '/../views',
    'commands' => [
        'elastic:search' => \Otus\Task10\App\Commands\SearchElasticSearchCommand::class,
    ],
    'elastic' => [
        'hosts' => [
            'http://localhost:9200'
        ]
    ]
];
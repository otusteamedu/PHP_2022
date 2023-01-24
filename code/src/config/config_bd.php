<?php

return [
    'conf_bd' => [
        'type' => 'mysql',
        'host' => 'db_mysql_hw_12',
        'db' => $_ENV['MYSQL_DATABASE'],
        'user' => $_ENV['MYSQL_ROOT'],
        'password' => $_ENV['MYSQL_ROOT_PASSWORD']
    ]
];

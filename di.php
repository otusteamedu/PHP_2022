<?php

use Psr\Container\ContainerInterface;
use function DI\factory;

return [
    Otus\Core\Config\AbstractConfig::class => function () {
        return new Otus\Core\Config\IniConfig(__DIR__ . '/config.ini');
    },
    'socket.chat' => factory(function (ContainerInterface $c) {
        $config = $c->get(Otus\Core\Config\AbstractConfig::class);
        $config = $config->get('chat');
        return new Otus\Core\Socket\Socket(
            $config['host'],
            $config['port'],
        );
    }),
    Otus\App\Command\ServerCommand::class => factory(function (ContainerInterface $c) {
        return new Otus\App\Command\ServerCommand($c->get('socket.chat'));
    }),
    Otus\App\Command\ClientCommand::class => factory(function (ContainerInterface $c) {
        return new Otus\App\Command\ClientCommand($c->get('socket.chat'));
    }),
];
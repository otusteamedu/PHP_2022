<?php

declare(strict_types=1);

use App\Chat\ChatInterface;
use App\Command\ClientCommand;
use App\Command\ListCommand;
use App\Command\ServerCommand;
use Psr\Container\ContainerInterface;

return [
    'commands' => [
        ServerCommand::ALIAS => static function (ContainerInterface $container): ServerCommand {
            return new ServerCommand($container->get(ChatInterface::class));
        },
        ClientCommand::ALIAS => static function (ContainerInterface $container): ClientCommand {
            return new ClientCommand($container->get(ChatInterface::class));
        },
        ListCommand::ALIAS => static function (): ListCommand {
            return new ListCommand();
        },
    ],
    'config' => [
        'defaultCommandName' => ListCommand::ALIAS,
    ],
];

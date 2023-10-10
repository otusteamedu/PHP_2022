<?php

declare(strict_types=1);

use App\Application\Chat\ClientInterface;
use App\Application\Chat\ServerInterface;
use App\Application\Command\ClientCommand;
use App\Application\Command\ServerCommand;
use App\Infrastructure\Command\ListCommand;
use Psr\Container\ContainerInterface;

return [
    'commands' => [
        ServerCommand::ALIAS => static function (ContainerInterface $container): ServerCommand {
            return new ServerCommand($container->get(ServerInterface::class));
        },
        ClientCommand::ALIAS => static function (ContainerInterface $container): ClientCommand {
            return new ClientCommand($container->get(ClientInterface::class));
        },
        ListCommand::ALIAS => static function (): ListCommand {
            return new ListCommand();
        },
    ],
    'config' => [
        'defaultCommandName' => ListCommand::ALIAS,
    ],
];

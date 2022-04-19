<?php

namespace Nka\OtusSocketChat;

use DI\Container;
use Nka\OtusSocketChat\Commands\ClientCommand;
use Nka\OtusSocketChat\Commands\ServerCommand;

class CommandResolver
{
    private static array $routes = [
        'server' => ServerCommand::class,
        'client' => ClientCommand::class
    ];

    public function __construct(private Container $container)
    {
    }

    public function resolve(string $commandName)
    {
        if (array_key_exists($commandName, self::$routes)) {

            $commandClass = self::$routes[$commandName];
            if (!class_exists($commandClass)) {
                throw new \Exception('Unknown command class.');
            }

            $command = $this->container->get($commandClass);
            return ($command)();
        }
        throw new \Exception('Unknown command.');
    }
}

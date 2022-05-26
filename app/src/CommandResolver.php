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

    private string $command;

    public function __construct(private Container $container)
    {
        $this->setCommand($_SERVER['argv'][1]);
    }

    public function validate()
    {
        if (!array_key_exists($this->getCommand(), self::$routes)) {
            throw new \Exception('Unknown command.');
        }
        return $this;
    }

    public function resolve()
    {
        $commandClass = self::$routes[$this->getCommand()];
        if (!class_exists($commandClass)) {
            throw new \Exception('Unknown command class.');
        }

        $command = $this->container->get($commandClass);
        return ($command)();
    }

    private function setCommand($command)
    {
        $this->command = $command;
    }

    private function getCommand()
    {
        return $this->command;
    }
}

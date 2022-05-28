<?php

namespace Nka\OtusSocketChat;

use DI\Container;
use Nka\OtusSocketChat\Commands\AbstractInvokeCommand;
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

    public function validate(): static
    {
        if (!array_key_exists($this->getCommand(), self::$routes)) {
            throw new \Exception('Unknown command.');
        }
        return $this;
    }

    public function resolve(): void
    {
        $commandClass = self::$routes[$this->getCommand()];
        if (!class_exists($commandClass)) {
            throw new \Exception('Unknown command class.');
        }

        /**
         * @var AbstractInvokeCommand $command
         */
        $command = $this->container->get($commandClass);
        ($command)();
    }

    private function setCommand($command): void
    {
        $this->command = $command;
    }

    private function getCommand(): string
    {
        return $this->command;
    }
}

<?php

namespace Dkozlov\Otus;

use Dkozlov\Otus\Command\AbstractCommand;
use Dkozlov\Otus\Command\AddEventCommand;
use Dkozlov\Otus\Command\ClearEventCommand;
use Dkozlov\Otus\Command\SendEventCommand;
use Dkozlov\Otus\Exception\CommandNotFoundException;
use Dkozlov\Otus\Exception\CommandParamsException;
use Dkozlov\Otus\Exception\ConfigNotFoundException;
use Dkozlov\Otus\Exception\DepencyNotFoundException;
use Dkozlov\Otus\Repository\Interface\EventRepositoryInterface;
use Exception;

class Application
{

    private static Config $config;

    /**
     * @throws ConfigNotFoundException
     */
    public function __construct(
        private readonly array $argv
    ) {
        self::$config = new Config(__DIR__ . '/../config/config.ini');
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $command = $this->getCommand($this->argv[1] ?? '');

        $command->execute();
    }

    public static function config(string $name): mixed
    {
        return self::$config->get($name);
    }

    /**
     * @throws CommandNotFoundException
     * @throws CommandParamsException
     * @throws DepencyNotFoundException
     */
    private function getCommand(string $commandName): AbstractCommand
    {
        $config = self::$config;

        return match($commandName) {
            'add' => new AddEventCommand($config->depency(EventRepositoryInterface::class), $this->argv),
            'send' => new SendEventCommand($config->depency(EventRepositoryInterface::class), $this->argv),
            'clear' => new ClearEventCommand($config->depency(EventRepositoryInterface::class), $this->argv),
            default => throw new CommandNotFoundException("Command \"$commandName\" not found")
        };
    }
}
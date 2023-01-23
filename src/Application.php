<?php

namespace Dkozlov\Otus;

use Dkozlov\Otus\Command\AbstractCommand;
use Dkozlov\Otus\Command\AddEventCommand;
use Dkozlov\Otus\Command\ClearEventCommand;
use Dkozlov\Otus\Command\SendEventCommand;
use Dkozlov\Otus\Exception\CommandNotFoundException;
use Dkozlov\Otus\Exception\CommandParamsException;
use Dkozlov\Otus\Exception\ConfigNotFoundException;
use Dkozlov\Otus\Repository\Dto\AddEventRequest;
use Dkozlov\Otus\Repository\Dto\GetEventRequest;
use Dkozlov\Otus\Repository\EventRepository;
use Dkozlov\Otus\Repository\Interface\EventRepositoryInterface;
use Exception;
use PDO;

class Application
{

    private static Config $config;

    private array $depencies;

    /**
     * @throws ConfigNotFoundException
     */
    public function __construct(
        private readonly array $argv
    ) {
        self::$config = new Config(__DIR__ . '/../config/config.ini');

        $this->depencies = require(__DIR__ . '/../app/depencies.php');
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
     */
    private function getCommand(string $commandName): AbstractCommand
    {
        return match($commandName) {
            'add' => new AddEventCommand($this->depencies[EventRepositoryInterface::class], $this->argv),
            'send' => new SendEventCommand($this->depencies[EventRepositoryInterface::class], $this->argv),
            'clear' => new ClearEventCommand($this->depencies[EventRepositoryInterface::class], $this->argv),
            default => throw new CommandNotFoundException("Command \"$commandName\" not found")
        };
    }
}
<?php

declare(strict_types=1);

namespace App;

use App\Command\AddEventCommand;
use App\Command\CommandInterface;
use App\Command\FlushAllCommand;
use App\Command\GetEventCommand;
use App\Command\ListCommand;
use App\Command\TestCommand;
use Exception;
use RuntimeException;

class Application
{
    private array $queryParams;
    private string $defaultCommand = 'list';

    public function __construct(private array $config)
    {
    }

    /**
     * @throws RuntimeException|Exception
     */
    public function run(): void
    {
        $command = $this->getCommand();

        $command->execute();
    }

    /**
     * @throws RuntimeException|Exception
     */
    private function getCommand(): CommandInterface
    {
        if (!isset($_SERVER['argv'])) {
            throw new RuntimeException("Error! Make sure the 'register_argc_argv' param in your php.ini is set to 1" . PHP_EOL);
        }

        $commandName = $_SERVER['argv'][1] ?? $this->defaultCommand;
        $this->queryParams = array_slice($_SERVER['argv'], 2);

        return $this->findCommand($commandName);
    }

    /**
     * @throws Exception
     */
    private function findCommand(string $commandName): CommandInterface
    {
        return match ($commandName) {
            'test' => new TestCommand($this->config),
            'event_add' => new AddEventCommand($this->config, $this->queryParams),
            'event_get' => new GetEventCommand($this->config, $this->queryParams),
            'flush_all' => new FlushAllCommand($this->config),
            default => new ListCommand(),
        };
    }

}

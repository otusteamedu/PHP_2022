<?php

declare(strict_types=1);

namespace App;

use App\Command\CommandInterface;
use App\Command\GetUserCommand;
use App\Command\GetUserTicketsCommand;
use App\Command\ListCommand;
use App\Command\TestCommand;
use App\Command\UpdateUserCommand;
use App\Storage\Storage;
use App\Storage\StorageInterface;
use Exception;
use RuntimeException;

class Application
{
    private array $queryParams;
    private string $defaultCommand = 'list';
    private StorageInterface $storage;

    public function __construct(array $config)
    {
        $this->storage = (new Storage($config))->getStorage();
    }

    /**
     * @throws RuntimeException|Exception
     */
    public function run(): void
    {
        $command = $this->getCommand();
        $command->execute();
        $command->printResult();
    }

    /**
     * @throws RuntimeException|Exception
     */
    private function getCommand(): CommandInterface
    {
        if (!isset($_SERVER['argv'])) {
            throw new RuntimeException(
                "Error!" .
                "Make sure the 'register_argc_argv'" .
                " param in your php.ini is set to 1" . PHP_EOL
            );
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
            'test' => new TestCommand($this->storage),
            'get_client' => new GetUserCommand($this->storage, $this->queryParams),
            'get_client_tickets' => new GetUserTicketsCommand($this->storage, $this->queryParams),
            'update_client' => new UpdateUserCommand($this->storage, $this->queryParams),
            default => new ListCommand(),
        };
    }
}

<?php

declare(strict_types=1);

namespace App;

use App\Command\ClientCommand;
use App\Command\CommandInterface;
use App\Command\ListCommand;
use App\Command\ServerCommand;
use Exception;

class Application
{
    private string $defaultCommand;
    private string $defaultSocketDir;
    private string $socketDir;
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->defaultCommand = 'list';
        $this->defaultSocketDir = __DIR__ . '/../var/socket/';
        $this->socketDir = $this->config['socket_dir'] ?? $this->defaultSocketDir;
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $command = $this->getCommand();

        $command->execute();
    }

    /**
     * @throws Exception
     */
    private function getCommand(): CommandInterface
    {
        if (!isset($_SERVER['argv']))
            throw new Exception("Error! Make sure the 'register_argc_argv' param in your php.ini is set to 1" . PHP_EOL);

        $commandName = $_SERVER['argv'][1] ?? $this->defaultCommand;

        return $this->findCommand($commandName);
    }

    /**
     * @throws Exception
     */
    private function findCommand(string $commandName): CommandInterface
    {
        return match ($commandName) {
            'server' => new ServerCommand($this->socketDir),
            'client' => new ClientCommand($this->socketDir),
            default => new ListCommand(),
        };
    }

}
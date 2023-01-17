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

  public function __construct(array $config)
    {
        $this->config = $config;
        $this->defaultCommand = 'list';
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
            default => new ListCommand(),
        };
    }

}
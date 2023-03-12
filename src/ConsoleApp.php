<?php

declare(strict_types=1);

namespace App;

use App\Infrastructure\Command\CommandInterface;

class ConsoleApp
{
    private CommandInterface $command;
    private array $arguments;

    public function __construct(CommandInterface $command, array $arguments)
    {
        $this->command = $command;
        $this->arguments = $arguments;
    }

    public function run(): void
    {
        $this->command->execute($this->arguments);
    }
}
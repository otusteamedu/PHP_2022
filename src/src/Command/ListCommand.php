<?php

declare(strict_types=1);

namespace App\Command;

class ListCommand implements CommandInterface
{
    public const ALIAS = 'list';

    public function execute(): void
    {
        $this->printAliases();
    }

    /**
     * @return array<string>
     */
    public function getAliases(): array
    {
        return [
            self::ALIAS,
            ServerCommand::ALIAS,
            ClientCommand::ALIAS
        ];
    }

    public function printAliases(): void
    {
        $aliases = $this->getAliases();
        printf("Available commands are:\n'%s'\n", implode(', ', $aliases));
    }
}

<?php

declare(strict_types=1);

namespace App\Command;

class ListCommand implements CommandInterface
{
    public function execute(): void
    {
        echo 'Available commands are:' . PHP_EOL . 'list, test, create, delete, get, search' . PHP_EOL;
    }
}

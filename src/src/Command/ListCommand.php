<?php

declare(strict_types=1);

namespace App\Command;

class ListCommand implements CommandInterface
{
    public function execute(): void
    {
        $this->printResult();
    }

    public function printResult(): void
    {
        echo 'Available commands are:' .
            PHP_EOL .
            'list, test, get_client, get_client_tickets, update_client' .
            PHP_EOL;
    }
}

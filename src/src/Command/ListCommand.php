<?php

declare(strict_types=1);

namespace App\Command;

class ListCommand extends AbstractCommand
{
    public function execute(): void
    {
        $this->message = 'Available commands are: list, test, event_add, event_get, flush_all';
    }
}

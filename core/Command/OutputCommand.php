<?php

namespace Otus\Task11\Core\Command;

use Otus\Task11\Core\Command\Contracts\OutputCommandContract;

class OutputCommand implements OutputCommandContract
{
    public function write(?string $message): void
    {
        echo $message;
    }
}
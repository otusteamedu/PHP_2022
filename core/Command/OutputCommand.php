<?php

namespace Otus\Task10\Core\Command;

use Otus\Task10\Core\Command\Contracts\OutputCommandContract;

class OutputCommand implements OutputCommandContract
{
    public function write(?string $message): void
    {
        echo $message;
    }
}
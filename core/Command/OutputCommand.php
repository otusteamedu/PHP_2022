<?php

namespace Otus\Task13\Core\Command;

use Otus\Task13\Core\Command\Contracts\OutputCommandContract;

class OutputCommand implements OutputCommandContract
{
    public function write(?string $message): void
    {
        echo $message;
    }
}
<?php

namespace Otus\Task12\Core\Command;

use Otus\Task12\Core\Command\Contracts\OutputCommandContract;

class OutputCommand implements OutputCommandContract
{
    public function write(?string $message): void
    {
        echo $message;
    }
}
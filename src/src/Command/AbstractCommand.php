<?php

declare(strict_types=1);

namespace App\Command;

abstract class AbstractCommand implements CommandInterface
{
    protected string $message;

    abstract public function execute(): void;

    public function getMessage(): string
    {
        return $this->message;
    }
}

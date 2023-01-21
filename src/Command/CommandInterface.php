<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Command;

interface CommandInterface
{
    public function execute(): void;
}
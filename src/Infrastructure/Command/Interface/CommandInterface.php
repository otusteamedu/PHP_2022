<?php

declare(strict_types=1);

namespace Dkozlov\Otus\Infrastructure\Command\Interface;

interface CommandInterface
{
    public function execute(): void;
}
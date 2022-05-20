<?php

declare(strict_types=1);

namespace App\Application\Contract;

interface LogEventInterface
{
    public function onLogAction(): void;
}
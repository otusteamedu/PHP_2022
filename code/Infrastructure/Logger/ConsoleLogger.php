<?php

declare(strict_types=1);

namespace App\Infrastructure\Logger;

use App\Application\Logger\LoggerInterface;

class ConsoleLogger implements LoggerInterface
{
    public function log(string $message): void
    {
        fwrite(STDOUT, $message);
    }
}
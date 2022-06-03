<?php

declare(strict_types=1);

namespace App\Service\Logger;

class ConsoleLogger implements LoggerInterface
{
    public function log(string $message): void
    {
        fwrite(STDOUT, $message);
    }
}
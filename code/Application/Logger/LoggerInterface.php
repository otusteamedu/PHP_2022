<?php

declare(strict_types=1);

namespace App\Application\Logger;

interface LoggerInterface
{
    public function log(string $message);
}
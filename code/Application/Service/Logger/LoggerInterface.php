<?php

declare(strict_types=1);

namespace App\Application\Service\Logger;

interface LoggerInterface
{
    public function log(string $message);
}
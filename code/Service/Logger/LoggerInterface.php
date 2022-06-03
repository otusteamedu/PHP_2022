<?php

declare(strict_types=1);

namespace App\Service\Logger;

interface LoggerInterface
{
    public function log(string $message);
}
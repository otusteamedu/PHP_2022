<?php

declare(strict_types=1);

namespace App\Logger;

class MyLogger implements MyInterfaceLogger
{
    public function log(string $message): void
    {
        fwrite(STDOUT, $message);
    }
}
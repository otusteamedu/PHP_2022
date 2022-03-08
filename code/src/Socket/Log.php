<?php

declare(strict_types=1);

namespace masteritua\Socket;

class Log
{
    public function display(string $message): void
    {
        echo date('Y-m-d H:i:s') . ' ' . $message . PHP_EOL;
    }
}
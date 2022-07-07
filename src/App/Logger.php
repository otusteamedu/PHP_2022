<?php
declare(strict_types=1);

namespace Qween\Php2022\App;

class Logger
{
    public function print(string $message): void
    {
        echo date('Y-m-d H:i:s'). ' ' . $message . PHP_EOL;
    }
}

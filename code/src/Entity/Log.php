<?php

namespace Otus\SocketApp\Entity;

class Log
{
    public function display(string $message): void
    {
        echo date('Y-m-d H:i:s'). ' ' . $message . PHP_EOL;
    }
}
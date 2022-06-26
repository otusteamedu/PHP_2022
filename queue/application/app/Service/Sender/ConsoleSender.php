<?php

namespace App\Service\Sender;

class ConsoleSender implements Sender
{

    public function send(string $message): void
    {
        echo "$message\n";
    }
}

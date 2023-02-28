<?php

namespace App\Service\Sender;

interface Sender
{
    public function send(string $message): void;
}

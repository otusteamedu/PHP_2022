<?php

namespace App\Application\Contracts;

interface SendMessageInterface
{
    public function sendMessage(string $text);
}
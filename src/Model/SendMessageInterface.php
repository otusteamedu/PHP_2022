<?php

declare(strict_types=1);

namespace App\Model;

interface SendMessageInterface
{
    public function send(string $to, string $message, string $subject = "");
}
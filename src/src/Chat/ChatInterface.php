<?php

declare(strict_types=1);

namespace App\Chat;

interface ChatInterface
{
    public function start(ServerMode $mode);

    public function getMessage(): string;

    public function sendMessage(string $message): bool;

    public function stop();
}

<?php

declare(strict_types=1);

namespace App\Application\Chat;

use App\Domain\Message;

interface ChatInterface
{
    public function start();

    public function getMessage(): Message;

    public function sendMessage(Message $message): bool;

    public function stop();
}

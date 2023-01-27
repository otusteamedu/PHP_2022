<?php

namespace Otus\App\Domain\Models\Interface;

/**
 * Messenger
 */
interface MessengerInterface
{
    public function send(string $email);
}

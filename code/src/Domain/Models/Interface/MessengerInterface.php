<?php

namespace Otus\App\Domain\Models\Interface;

interface MessengerInterface
{
    public function send(string $email);
}
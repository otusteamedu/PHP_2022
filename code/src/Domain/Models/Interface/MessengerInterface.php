<?php

namespace Otus\Mvc\Domain\Models\Interface;

interface MessengerInterface
{
    public function send(string $email);
}
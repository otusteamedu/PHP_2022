<?php

declare(strict_types=1);

namespace Svatel\Code\Domain;

use http\Exception\InvalidArgumentException;

final class Email
{
    private string $email;

    public function __construct(string $email) {
        $this->assert($email);
        $this->email = $email;
    }

    private function assert(string $email): void
    {
        if (!preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/', $email)) {
            throw new InvalidArgumentException('Не валидна почта');
        }
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}

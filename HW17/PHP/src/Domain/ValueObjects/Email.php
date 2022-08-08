<?php

declare(strict_types = 1);

namespace App\Domain\ValueObjects;

use http\Exception\InvalidArgumentException;

class Email
{
    protected string $email;

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function __construct(string $email)
    {
        if (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email))
            $this->email = $email;
        else
            throw new \InvalidArgumentException("Неверный формат email адреса");
    }
}
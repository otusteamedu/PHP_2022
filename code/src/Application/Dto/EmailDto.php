<?php

declare(strict_types=1);

namespace Svatel\Code\Application\Dto;

use Svatel\Code\Domain\Email;

final class EmailDto
{
    private Email $email;
    private bool $checkEmail;

    public function __construct(Email $email, bool $checkEmail)
    {
        $this->email = $email;
        $this->checkEmail = $checkEmail;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getCheck(): bool
    {
        return $this->checkEmail;
    }
}

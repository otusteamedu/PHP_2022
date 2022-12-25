<?php

declare(strict_types=1);

namespace Maldoshina\Php2022;

class EmailValidator
{
    /**
     * @param string|null $email
     *
     * @return bool
     */
    public function validate(?string $email): bool
    {
        if (!$email) {
            return false;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) && checkdnsrr(explode('@', $email)[1])) {
            return true;
        }

        return false;
    }
}


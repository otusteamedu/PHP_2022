<?php

declare(strict_types=1);

namespace Maldoshina\Php2022;

class EmailValidator
{
    /**
     * @param string $email
     *
     * @return bool
     * @throws \Exception
     */
    public function validate(string $email): bool
    {
        if (!$email) {
            throw new \Exception("Передан пустой email");
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) && checkdnsrr(explode('@', $email)[1])) {
            return true;
        }

        throw new \Exception("email " . $email . " не валиден");
    }
}

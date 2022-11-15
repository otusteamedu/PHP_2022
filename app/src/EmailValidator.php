<?php

declare(strict_types=1);

namespace Eliasjump\EmailVerification;

class EmailValidator
{
    private const PATTERN = '/^(?=.{1,64}@)[A-Za-z0-9_-]+(.[A-Za-z0-9_-]+)*@[^-]' .
    '[A-Za-z0-9-]+(.[A-Za-z0-9-]+)*(.[A-Za-z]{2,})$/';

    public static function run(array $emails): array
    {
        $errors = [];
        foreach ($emails as $email) {
            $email = trim($email);
            if ($email == '') {
                $errors[] = "Пустая строка";
                continue;
            }

            if (!preg_match(static::PATTERN, $email)) {
                $errors[] = "Email {$email} - не валидный";
                continue;
            }
            $mx = explode('@', $email)[1];
            if (!checkdnsrr($mx, 'MX')) {
                $errors[] = "MX {$mx} - не валидный";
            }
        }

        return $errors;
    }
}

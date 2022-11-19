<?php

declare(strict_types=1);

namespace Eliasjump\EmailVerification;

class EmailValidator
{
    private const PATTERN = '/^(?=.{1,64}@)[A-Za-z0-9_-]+(.[A-Za-z0-9_-]+)*@[^-]' .
    '[A-Za-z0-9-]+(.[A-Za-z0-9-]+)*(.[A-Za-z]{2,})$/';

    /**
     * @throws ValidateException
     */
    public function validate(string $email): void
    {
        $email = trim($email);
        $this->validateOnEmpty($email);
        $this->validateByPregMatch($email);
        $this->validateByMX($email);
    }

    /**
     * @throws ValidateException
     */
    private function validateOnEmpty(string $email): void
    {
        if ($email == '') {
            throw new ValidateException("Пустая строка");
        }
    }

    /**
     * @throws ValidateException
     */
    private function validateByPregMatch(string $email): void
    {
        if (!preg_match(static::PATTERN, $email)) {
            throw new ValidateException("Email {$email} - не валидный");
        }
    }

    /**
     * @throws ValidateException
     */
    private function validateByMX(string $email): void
    {
        $mx = explode('@', $email)[1];
        if (!checkdnsrr($mx, 'MX')) {
            throw new ValidateException("MX {$mx} - не валидный");
        }
    }
}

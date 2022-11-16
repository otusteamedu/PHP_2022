<?php

declare(strict_types=1);

namespace Eliasjump\EmailVerification;

class EmailValidator
{
    private const PATTERN = '/^(?=.{1,64}@)[A-Za-z0-9_-]+(.[A-Za-z0-9_-]+)*@[^-]'.
    '[A-Za-z0-9-]+(.[A-Za-z0-9-]+)*(.[A-Za-z]{2,})$/';

    private array $emails;
    private array $errors = [];

    public function __construct(?array $emails = [])
    {
        $this->emails = $emails;
    }

    public function run(): array
    {
        foreach ($this->emails as $email) {
            $email = trim($email);
            if (!$this->validateEmail($email)) {
                continue;
            }
        }

        return $this->errors;
    }

    private function validateEmail(string $email): bool
    {
        if (!$this->validateOnEmpty($email)) {
            return false;
        }
        if (!$this->validateByPregMatch($email)) {
            return false;
        }
        if (!$this->validateByMX($email)) {
            return false;
        }
        return true;
    }

    private function validateOnEmpty(string $email): bool
    {
        if ($email == '') {
            $this->errors[] = "Пустая строка";
            return false;
        }
        return true;
    }

    private function validateByPregMatch(string $email): bool
    {
        if (!preg_match(static::PATTERN, $email)) {
            $this->errors[] = "Email {$email} - не валидный";
            return false;
        }
        return true;
    }

    private function validateByMX(string $email): bool
    {
        $mx = explode('@', $email)[1];
        if (!checkdnsrr($mx, 'MX')) {
            $this->errors[] = "MX {$mx} - не валидный";
            return false;
        }
        return true;
    }

}

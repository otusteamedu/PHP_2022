<?php

namespace Email\App\Service;

class EmailValidator
{

    private const INCORRECT_ADDRESS_ERROR = 'Некорректный адрес e-mail.';
    private const INCORRECT_ADDRESS_HOST = 'Некорректный хост.';
    private const BAD_REQUEST_CODE = 400;

    /**
     * @throws \Exception
     */
    public function validate(string $email): void
    {
        if (!$this->validateAddress($email)) {
            throw new \Exception(self::INCORRECT_ADDRESS_ERROR, self::BAD_REQUEST_CODE);
        }

        if (!$this->validateDnsMx($email)) {
            throw new \Exception(self::INCORRECT_ADDRESS_HOST, self::BAD_REQUEST_CODE);
        }
    }

    private function validateAddress(string $email): bool
    {
        $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

        return (bool)preg_match($regex, $email);
    }

    private function validateDnsMx(string $email): bool
    {
        preg_match('/.*@(.*)/', $email, $match);
        $domain = (string)$match[1];

        return checkdnsrr($domain);
    }
}
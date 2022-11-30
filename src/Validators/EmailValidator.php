<?php

declare(strict_types=1);

namespace Pinguk\Validator\Validators;

use Pinguk\Validator\Validation;

class EmailValidator
{
    const BAD_STRING = 'Эл. почта некорректная. Пример корректной: andrew@mail.ru';
    const BAD_MX_RECORD = 'Некорректная MX-запись';

    /**
     * @return Validation[]
     */
    public function validateEmails(array $emails): array
    {
        $result = [];

        foreach ($emails as $email) {
            $result[] = $this->validate($email);
        }

        return $result;
    }

    public function validate(string $email): Validation
    {
        $validation = new Validation($email);

        $this->validateString($validation);
        $this->validateMXRecord($validation);

        return $validation;
    }

    public function validateString(Validation $validation): void
    {
        $regex = '/^([A-Za-z0-9]+@[A-Za-z]+\.[A-Za-z]+)$/';

        $done = !!preg_match($regex, $validation->value);
        if (!$done) {
            $validation->isValid = false;
            $validation->errors[] = self::BAD_STRING;
        }
    }

    public function validateMXRecord(Validation $validation): void
    {
        $hostname = explode('@', $validation->value)[1];
        getmxrr($hostname, $hosts);

        $done = isset($hosts) && !empty($hosts);
        if (!$done) {
            $validation->isValid = false;
            $validation->errors[] = self::BAD_MX_RECORD;
        }
    }
}

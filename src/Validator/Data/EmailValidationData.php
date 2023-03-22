<?php

declare(strict_types=1);

namespace Project\Validator\Data;

class EmailValidationData
{
    /**
     * @var string
     */
    public string $email;

    /**
     * @param string $email
     *
     * @return EmailValidationData
     */
    public static function create(
        string $email
    ): EmailValidationData
    {
        $data = new self();
        $data->email = $email;
        return $data;
    }
}
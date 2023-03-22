<?php

declare(strict_types=1);

namespace Project\Validator\Email;

use Project\Validator\Data\EmailValidationData;

class Validator
{
    /**
     * @var bool
     */
    private bool $checkEmail;

    /**
     * @var bool
     */
    private bool $checkMX;

    /**
     * @param bool $checkEmail
     * @param bool $checkMX
     */
    public function __construct(
        bool $checkEmail = true,
        bool $checkMX = true
    ) {
        $this->checkEmail = $checkEmail;
        $this->checkMX = $checkMX;
    }

    /**
     * @param EmailValidationData $emailValidationData
     * @return bool
     * @throws EmailValidatorException
     */
    public function validation(EmailValidationData $emailValidationData): bool
    {
        if ($this->checkEmail) {
            $this->emailFilter($emailValidationData->email);
        }

        if ($this->checkMX) {
            $this->mxFilter($this->getEmailHost($emailValidationData->email));
        }

        return true;
    }

    /**
     * @param string $email
     * @return void
     * @throws EmailValidatorException
     */
    private function emailFilter(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new EmailValidatorException('Email not valid');
        }
    }

    /**
     * @param string $host
     * @return void
     * @throws EmailValidatorException
     */
    private function mxFilter(string $host): void
    {
        if (!checkdnsrr($host)) {
            throw new EmailValidatorException("MX $host - не валидный");
        }
    }

    /**
     * @param string $email
     * @return string
     */
    private function getEmailHost(string $email): string
    {
        return explode('@', $email)[1];
    }
}

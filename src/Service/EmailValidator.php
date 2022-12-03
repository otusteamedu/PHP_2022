<?php

namespace Octopus\Php2022\Service;

use hbattat\VerifyEmail;

class EmailValidator
{
    private const VERIFIER_EMAIL = 'leheted875@edinel.com';
    private VerifyEmail $validator;

    public function __construct()
    {
        $this->validator = new VerifyEmail();
        $this->setVerifierEmail(self::VERIFIER_EMAIL);
    }

    public function setVerifierEmail(string $email): void
    {
        $this->validator->set_verifier_email($email);
    }

    public function setEmail(string $email): void
    {
        $this->validator->set_email($email);
    }

    public function getErrors(): array
    {
        return $this->validator->get_errors();
    }

    public function verify($email): bool
    {
        $this->setEmail($email);

        return $this->validator->verify();
    }
}

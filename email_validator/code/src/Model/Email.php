<?php

declare(strict_types=1);
namespace Mapaxa\EmailVerificationApp\Model;


class Email
{
    private string $email;
    private string $domain;

    public function __construct($email, $domain)
    {
        $this->email = $email;
        $this->domain = $domain;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }


}
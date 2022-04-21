<?php

declare(strict_types=1);
namespace Mapaxa\EmailVerificationApp\Dto;


class Email
{
    public string $email;
    public string $domain;

    public function __construct(string $email, string $domain)
    {
        $this->email = $email;
        $this->domain = $domain;
    }

}
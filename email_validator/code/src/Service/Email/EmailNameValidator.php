<?php

declare(strict_types=1);


namespace Mapaxa\EmailVerificationApp\Service\Email;


class EmailNameValidator
{
    private array $emails;

    public function __construct(array $emails)
    {
        $this->emails = $emails;
    }


    public function getValidEmailNames() {
        //валидные имена имэйлов
        $validEmailNames = array_filter($this->emails, function($email) {
            return $this->isValidEmailName($email);
        });

        return $validEmailNames;
    }

    private function isValidEmailName(string $email): ?string
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null ;
    }
}
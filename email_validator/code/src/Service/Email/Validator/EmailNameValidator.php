<?php

declare(strict_types=1);


namespace Mapaxa\EmailVerificationApp\Service\Email\Validator;


use Mapaxa\EmailVerificationApp\Service\Email\EmailValidatorInterface;

class EmailNameValidator implements EmailValidatorInterface
{
    public function validate(array $emails): ?array
    {
        //валидные имена имэйлов
        $validEmailNames = array_filter($emails, function($email) {
            return $this->isValidEmailName($email);
        });

        return $validEmailNames;
    }

    private function isValidEmailName(string $email): ?string
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null ;
    }
}
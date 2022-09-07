<?php

declare(strict_types=1);


namespace Mapaxa\EmailVerificationApp\Service\Email;


interface EmailValidatorInterface
{
    public function validate(array $emails);
}
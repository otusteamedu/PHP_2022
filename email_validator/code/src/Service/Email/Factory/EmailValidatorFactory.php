<?php

declare(strict_types=1);

namespace Mapaxa\EmailVerificationApp\Service\Email\Factory;


class EmailValidatorFactory
{
    public static function createEmailValidator(string $className)
    {
        return new $className();
    }
}
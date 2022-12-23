<?php

declare(strict_types=1);

namespace Src\Domain\UseCases;

use Src\Application\Exceptions\SimpleValidationException;

final class SimpleValidation
{
    /**
     * @param string $email
     * @return void
     * @throws SimpleValidationException
     */
    public function validate(string $email): void
    {
        if (filter_var(value: $email, filter: FILTER_VALIDATE_EMAIL) === false) {
            throw new SimpleValidationException(message: 'filter_var_errors');
        }
    }
}

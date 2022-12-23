<?php

declare(strict_types=1);

namespace Src\Services\Modules;

use Src\Services\Modules\Contracts\Validator;

final class SimpleValidation implements Validator
{
    /**
     * @param string $email
     * @return string
     */
    public function validate(string $email): string
    {
        if (filter_var(value: $email, filter: FILTER_VALIDATE_EMAIL) === false) {
            return 'filter_var_errors';
        }

        return '';
    }
}

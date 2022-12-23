<?php

declare(strict_types=1);

namespace Src\Services;

use Src\Services\Modules\Contracts\Validator;
use Src\Services\Modules\{MxRecordsValidation, RegexpValidation, SimpleValidation, WorldMxRecordsValidation};

final class EmailValidatorService
{
    private string|array $emails;

    public function __construct(string|array $emails)
    {
        if (is_string($emails)) {
            $emails = [$emails];
        }

        $this->emails = $emails;
    }

    /**
     * @return array
     */
    public function isEmailValid(): array
    {
        $validators = $this->instantiateValidators();

        $result = [];

        foreach ($validators as $validator) {
            if (is_array($this->emails) && is_a(object_or_class: $validator, class: Validator::class)) {
                foreach ($this->emails as $email) {
                    $result_validation = $validator->validate(email: (string) $email);

                    if (! empty($result_validation)) {
                        $result[$email][] = $result_validation;
                    }
                }
            }
        }

        return $result;
    }

    /*
    |-------------------------------------------------------------------------------------------------------------------
    | PRIVATE FUNCTIONS
    |-------------------------------------------------------------------------------------------------------------------
    */

    /**
     * @return array
     */
    private function instantiateValidators(): array
    {
        return [
            new SimpleValidation(),
            new RegexpValidation(),
            new MxRecordsValidation(),
            new WorldMxRecordsValidation(),
        ];
    }
}

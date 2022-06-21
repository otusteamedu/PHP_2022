<?php


namespace Decole\Hw13\Core\Validators\SubValidators;


class IsNullValidator implements SubValidatorInterface
{
    public static function validate(mixed $value): bool
    {
        return $value === null;
    }
}
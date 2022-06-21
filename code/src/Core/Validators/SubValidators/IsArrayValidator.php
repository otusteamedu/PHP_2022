<?php


namespace Decole\Hw13\Core\Validators\SubValidators;


class IsArrayValidator implements SubValidatorInterface
{
    public static function validate(mixed $value): bool
    {
        return is_array($value) && !empty($value);
    }
}
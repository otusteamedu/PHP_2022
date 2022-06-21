<?php


namespace Decole\Hw13\Core\Validators\SubValidators;


class IsEmptyStringValidator implements SubValidatorInterface
{
    public static function validate(mixed $value): bool
    {
        return mb_strlen($value) === 0;
    }
}
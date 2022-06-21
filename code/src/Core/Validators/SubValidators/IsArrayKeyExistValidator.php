<?php


namespace Decole\Hw13\Core\Validators\SubValidators;


class IsArrayKeyExistValidator implements SubValidatorInterface
{
    public static function validate(mixed $value): bool
    {
        return array_key_exists($value[0], $value[1]);
    }
}
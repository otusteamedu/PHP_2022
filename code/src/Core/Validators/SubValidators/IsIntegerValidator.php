<?php


namespace Decole\Hw13\Core\Validators\SubValidators;


class IsIntegerValidator implements SubValidatorInterface
{
    public static function validate(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
    }
}
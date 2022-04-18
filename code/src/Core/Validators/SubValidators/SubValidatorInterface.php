<?php

namespace Decole\Hw13\Core\Validators\SubValidators;

interface SubValidatorInterface
{
    public static function validate(mixed $value): bool;
}
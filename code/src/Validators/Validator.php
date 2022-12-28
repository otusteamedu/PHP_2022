<?php

namespace Ppro\Hw13\Validators;

class Validator
{
    public static function validateParams(array $params): void
    {
        if (count(end($params)) !== 2)
            throw new \Exception('Query string is not correct');
    }
}
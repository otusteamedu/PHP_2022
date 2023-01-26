<?php

declare(strict_types=1);

namespace Core;

class Validator
{
    public function validateBrackets(string $request_string): bool
    {
        return preg_match("/^[^()\n]*+(\((?>[^()\n]|(?1))*+\)[^()\n]*+)++$/", $request_string) > 0;
    }
}

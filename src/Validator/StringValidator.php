<?php

namespace Kirillov\Validator;

use Kirillov\Exception\SymbolException;
use Kirillov\ValueObject\StatusCode;

class StringValidator
{
    public function validate(string $brackets): bool
    {
        $count = 0;

        if ($brackets[0] === ')') {
            throw new SymbolException('String must start with \')\'');
        }

        if ($brackets[strlen($brackets) - 1] === '(') {
            throw new SymbolException('String must end with \')\'');
        }

        for ($i = 0; $i < strlen($brackets); $i++) {
            if ($brackets[$i] === '(') {
                $count++;
                continue;
            }

            if ($brackets[$i] === ')') {
                $count--;
                continue;
            }

            throw new SymbolException('String contains wrong symbols.');
        }

        return $count === 0;
    }
}

<?php

namespace Kirillov\Validator;

use Exception;
use Kirillov\ValueObject\StatusCode;

class StringValidator
{
    public function validate(string $brackets): bool
    {
        $count = 0;

        if ($brackets[0] === ')') {
            http_response_code(StatusCode::BAD_REQUEST);
            throw new Exception('String must start with \')\'');
        }

        if ($brackets[strlen($brackets) - 1] === '(') {
            http_response_code(StatusCode::BAD_REQUEST);
            throw new Exception('String must end with \')\'');
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

            http_response_code(StatusCode::BAD_REQUEST);
            throw new Exception('String contains wrong symbols.');
        }

        return $count === 0;
    }
}

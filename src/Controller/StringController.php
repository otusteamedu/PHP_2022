<?php

namespace Kirillov\Controller;

use Kirillov\Validator\StringValidator;
use Kirillov\ValueObject\StatusCode;

class StringController
{
    public function __construct(
        private StringValidator $stringValidator
    ) { }

    public function validate(string $brackets)
    {
        $isValid = $this->stringValidator->validate($brackets);

        http_response_code(StatusCode::SUCCESS);
        return $isValid ? 'String is valid.' : 'String is not valid.';
    }
}

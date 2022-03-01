<?php

namespace Kirillov\Controller;

use Kirillov\Validator\StringValidator;
use Exception;
use Kirillov\ValueObject\StatusCode;

class StringController
{
    public function __construct(
        private StringValidator $stringValidator
    ) {
    }

    public function validate(string $brackets)
    {
        try {
            $isValid = $this->stringValidator->validate($brackets);
            http_response_code(StatusCode::SUCCESS);
            return $isValid ? 'String is valid.' : 'String is not valid.';
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}

<?php

namespace Onbalt\Validator;

require_once('ValidateBrackets.php');

class ValidatorRequest
{

    public function handleRequest(array $requestArray): bool
    {
        $resultIsValid = false;
        if (isset($requestArray['string'])) {
            $bracketsValidator = new ValidateBrackets();
            $resultIsValid = $bracketsValidator->isValid($requestArray['string']);
        }
        return $resultIsValid;
    }
}
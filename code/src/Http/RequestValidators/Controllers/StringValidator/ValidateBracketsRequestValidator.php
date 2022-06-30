<?php

namespace Nsavelev\Hw4\Http\RequestValidators\Controllers\StringValidator;

use Nsavelev\Hw4\Http\Controllers\StringValidator\Exceptions\EmptyPostException;
use Nsavelev\Hw4\Http\Controllers\StringValidator\Exceptions\EmptyStringException;
use Nsavelev\Hw4\Http\Controllers\StringValidator\Exceptions\WrongRequestMethodException;
use Nsavelev\Hw4\Http\RequestValidators\Interfaces\RequestValidatorInterface;

class ValidateBracketsRequestValidator implements RequestValidatorInterface
{
    /**
     * @return void
     * @throws EmptyPostException
     * @throws EmptyStringException
     * @throws WrongRequestMethodException
     */
    public function validate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new WrongRequestMethodException('Request method is wrong. It mast to be a POST.');
        }

        if (empty($_POST)) {
            throw new EmptyPostException('Body of post request is empty.');
        }

        if (empty($_POST['string'])) {
            throw new EmptyStringException('String is empty.');
        }
    }
}
<?php

namespace Nsavelev\Hw4\Http\Controllers\StringValidator;

use Nsavelev\Hw4\Http\Controllers\StringValidator\Exceptions\EmptyStringException;
use Nsavelev\Hw4\Http\Controllers\StringValidator\Exceptions\InvalidStringException;
use Nsavelev\Hw4\Http\Controllers\StringValidator\Exceptions\EmptyPostException;
use Nsavelev\Hw4\Http\Controllers\StringValidator\Exceptions\WrongRequestMethodException;
use Nsavelev\Hw4\Http\RequestValidators\Controllers\StringValidator\ValidateBracketsRequestValidator;

class StringValidatorController
{
    /** @var StringValidatorManager */
    private StringValidatorManager $stringValidatorManager;

    public function __construct()
    {
        $this->stringValidatorManager = new StringValidatorManager();
    }

    /**
     * @return string
     */
    public function validateBrackets(): string
    {
        try {
            $validator = new ValidateBracketsRequestValidator();
            $validator->validate();

            $stringWithBrackets = $_POST['string'];

            $isStringValidate = $this->stringValidatorManager->validateBrackets($stringWithBrackets);

            if (empty($isStringValidate)) {
                throw new InvalidStringException('String is invalid');
            }

            return 'String is valid';

        } catch (WrongRequestMethodException $exception) {
            http_response_code(405);
            \header('Allow: POST');

            return $exception->getMessage();

        } catch (EmptyPostException|EmptyStringException|InvalidStringException $exception) {
            http_response_code(400);

            return $exception->getMessage();

        } catch (\Exception $exception) {
            return 'Unexpected error';
        }
    }
}
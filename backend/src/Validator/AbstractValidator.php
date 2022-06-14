<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class AbstractValidator
{
    protected array $inputData;
    protected ConstraintViolationListInterface $validatedResult;

    public function __construct(
        protected readonly ValidatorInterface $validator,
    )
    {
    }

    public function validate(array $data): ConstraintViolationListInterface
    {
        $this->inputData = $data;
        $this->validatedResult = $this->validator->validate($data, $this->rules());
        return $this->validatedResult;
    }

    public function getInputData(): array
    {
        return $this->inputData;
    }

    public function getErrors(): array
    {
        $errors = [];
        if (empty($this->validatedResult)) {
            return [];
        }
        foreach ($this->validatedResult as $error) {
            $field = trim($error->getPropertyPath(), '[]');
            $field = str_replace('][', '.',$field);
            $errors[$field] = $error->getMessage();
        }
        return $errors;
    }

    abstract protected function rules(): Assert\Collection;
}
<?php

namespace App\Service\CookingFood\Exception;

use Symfony\Component\HttpFoundation\Response;

class ProductValidationException extends \Exception
{
    protected $code = 422;

    public function __construct(
        private readonly array $errors
    )
    {
        parent::__construct('', Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
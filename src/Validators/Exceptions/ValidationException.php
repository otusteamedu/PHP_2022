<?php

declare(strict_types=1);

namespace Philip\Otus\Validators\Exceptions;

use Exception;

class ValidationException extends Exception
{
    protected $code = 422;
    protected array $errors = [];

    public function __construct(array $errors)
    {
        parent::__construct("", $this->code);
        $this->errors = $errors;
    }

    public function errors(): array
    {
        return $this->errors;
    }
}
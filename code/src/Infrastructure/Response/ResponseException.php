<?php

declare(strict_types=1);

namespace App\Infrastructure\Response;

class ResponseException extends ResponseAbstract
{
    public const STATUS_CODE = 500;

    protected array $messages = ['message' => 'exception', 'errors' => []];

    public function __construct(array $errors)
    {
        if (!empty($errors)) {
            $this->messages['errors'] = $errors;
        }
    }
}

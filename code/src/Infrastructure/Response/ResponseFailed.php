<?php

declare(strict_types=1);

namespace App\Infrastructure\Response;

class ResponseFailed extends ResponseAbstract
{
    public const STATUS_CODE = 400;

    protected array $messages = ['message' => 'validation_failed', 'errors' => []];

    public function __construct(array $errors)
    {
        if (!empty($errors)) {
            $this->messages['errors'] = $errors;
        }
    }
}

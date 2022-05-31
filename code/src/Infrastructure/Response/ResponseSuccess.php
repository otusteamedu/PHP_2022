<?php

declare(strict_types=1);

namespace App\Infrastructure\Response;

class ResponseSuccess extends ResponseAbstract
{
    public const STATUS_CODE = 200;

    protected array $messages = ['success' => 'All is okay'];

    public function __construct(string $message= '')
    {
        if (empty($message) === false) {
            $this->messages['success'] = $message;
        }
    }
}

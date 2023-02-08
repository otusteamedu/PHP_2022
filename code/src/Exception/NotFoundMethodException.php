<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw12\Exception;

class NotFoundMethodException extends AppException
{
    protected $message;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = "Method \"$message()\" not found!";
        parent::__construct($message, $code, $previous);
    }
}
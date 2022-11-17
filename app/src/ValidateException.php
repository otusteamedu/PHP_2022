<?php

declare(strict_types=1);

namespace Eliasjump\EmailVerification;

use Exception;
use Throwable;

class ValidateException extends Exception
{
    public int $httpCode = 422;

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

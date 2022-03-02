<?php

namespace Kirillov\Exception;

use Exception;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use Kirillov\ValueObject\StatusCode;

class InvalidMethodException extends Exception
{
    private const ALLOWED_METHOD_ERROR = 'Only POST method allowed.';

    public function __construct(
        string $message = self::ALLOWED_METHOD_ERROR,
        int $code = StatusCode::METHOD_NOT_ALLOWED,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

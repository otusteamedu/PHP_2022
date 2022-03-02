<?php

namespace Kirillov\Exception;

use Exception;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use Kirillov\ValueObject\StatusCode;

class InvalidPathException extends Exception
{
    private const INVALID_PATH_MESSAGE = 'Invalid path.';

    public function __construct(
        string $message = self::INVALID_PATH_MESSAGE,
        int $code = StatusCode::BAD_REQUEST,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

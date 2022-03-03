<?php

namespace Kirillov\Exception;

use Exception;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use Kirillov\ValueObject\StatusCode;

class SymbolException extends Exception
{
    public function __construct(
        string $message = "",
        int $code = StatusCode::BAD_REQUEST,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}

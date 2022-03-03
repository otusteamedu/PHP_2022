<?php

namespace Exception;

use Exception;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class FileNotFoundException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
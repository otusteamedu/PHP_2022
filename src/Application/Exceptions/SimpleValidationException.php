<?php

declare(strict_types=1);

namespace Src\Application\Exceptions;

final class SimpleValidationException extends \Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct(message: $message, code: $code, previous: $previous);
    }
}

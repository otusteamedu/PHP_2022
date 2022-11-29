<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw6\Exception;

class SocketException extends AppException
{
    protected $message;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
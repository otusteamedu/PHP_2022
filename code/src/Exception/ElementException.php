<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw11\Exception;

class ElementException extends AppException
{
    protected $message;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
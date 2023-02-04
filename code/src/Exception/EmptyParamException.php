<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw11\Exception;

class EmptyParamException extends AppException
{
    protected $message;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = "Parameter \"$message\" is empty!";
        parent::__construct($message, $code, $previous);
    }
}
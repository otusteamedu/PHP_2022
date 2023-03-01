<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Libs\Exception;

class BaseException extends \Exception
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
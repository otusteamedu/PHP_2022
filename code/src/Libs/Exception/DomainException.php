<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw14\Libs\Exception;

class DomainException extends BaseException
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
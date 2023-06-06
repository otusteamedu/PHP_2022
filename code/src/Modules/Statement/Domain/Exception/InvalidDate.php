<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16\Modules\Statement\Domain\Exception;

use Nikcrazy37\Hw16\Libs\Exception\DomainException;

class InvalidDate extends DomainException
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
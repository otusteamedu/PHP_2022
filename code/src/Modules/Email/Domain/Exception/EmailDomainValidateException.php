<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw13\Modules\Email\Domain\Exception;

use Nikcrazy37\Hw13\Libs\Exception\DomainException;

class EmailDomainValidateException extends DomainException
{
    protected $message;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = "Incorrect email mx record!";

        parent::__construct($message, $code, $previous);
    }
}
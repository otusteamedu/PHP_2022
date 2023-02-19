<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw13\Modules\Email\Domain\Exception;

use Nikcrazy37\Hw13\Libs\Exception\DomainException;

class EmailNameValidateException extends DomainException
{
    protected $message;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = "Incorrect email name!";

        parent::__construct($message, $code, $previous);
    }
}
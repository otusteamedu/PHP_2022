<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw13\Modules\Email\Application\Exception;

use Nikcrazy37\Hw13\Libs\Exception\ApplicationException;

class NotEmailException extends ApplicationException
{
    protected $message;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = "It's not email!";

        parent::__construct($message, $code, $previous);
    }
}
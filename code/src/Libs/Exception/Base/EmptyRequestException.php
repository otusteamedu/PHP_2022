<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw13\Libs\Exception\Base;

use Nikcrazy37\Hw13\Libs\Exception\BaseException;

class EmptyRequestException extends BaseException
{
    protected $message;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = "Request is empty!";

        parent::__construct($message, $code, $previous);
    }
}
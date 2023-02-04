<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw11\Exception\Element;

use Nikcrazy37\Hw11\Exception\ElementException;

class UpdateElementException extends ElementException
{
    protected $message;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = "Failed to update element $message!";
        parent::__construct($message, $code, $previous);
    }
}
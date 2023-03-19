<?php

namespace Ppro\Hw20\Exceptions;

class KitchenException extends \Exception
{
    public function __construct($msg = "", $code = 0, $previous = null)
    {
        parent::__construct($msg, $code, $previous);
    }
}
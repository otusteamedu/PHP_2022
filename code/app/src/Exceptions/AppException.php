<?php
declare(strict_types = 1);

namespace Ppro\Hw27\App\Exceptions;

class AppException extends \Exception
{
    public function __construct($msg = "", $code = 0, $previous = null)
    {
        parent::__construct($msg, $code, $previous);
    }
}

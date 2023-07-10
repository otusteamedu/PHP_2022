<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw20\libs\Exception;

class NotFoundElementException extends \Exception
{
    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = "Not found element: \"$message\"!";
        parent::__construct($message, $code, $previous);
    }
}
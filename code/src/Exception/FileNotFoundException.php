<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw5\Exception;

class FileNotFoundException extends AppException
{
    protected $message;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = "[ERROR] File not found!";
        parent::__construct($message, $code, $previous);
    }
}
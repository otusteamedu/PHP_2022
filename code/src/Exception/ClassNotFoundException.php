<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw6\Exception;

class ClassNotFoundException extends AppException
{
    protected $message;

    public function __construct($message = "", $code = 0, \Throwable $previous = null)
    {
        $message = "Класс не найден!";

        parent::__construct($message, $code, $previous);
    }
}
<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw10\Exception;

class NotFoundException extends AppException
{
    protected $message;

    public function __construct($message = "По заданному запросу товаров не найдено!", $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
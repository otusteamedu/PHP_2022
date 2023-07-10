<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw20\Libs;

class ExceptionHandler
{
    public static function printMessage($e): void
    {
        http_response_code($e->getCode());

        print_r($e->getMessage());
        print_r($e->getTraceAsString());
    }
}
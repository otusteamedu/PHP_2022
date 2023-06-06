<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16\Libs;

class ExceptionHandler
{
    public static function printMessage($e)
    {
        http_response_code($e->getCode());

        print_r($e->getMessage());

        echo "<br><pre>";
        print_r($e->getTraceAsString());
        echo "</pre>";
    }
}
<?php

declare(strict_types=1);

namespace TemaGo\OtusTest;

class NumberParser
{
    function parse($text) {
        $number = preg_replace('/[^0-9]/', '', $text);
        return $number;
    }
}

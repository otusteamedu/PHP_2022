<?php

namespace Anosovm\FirstPackage;

class FirstPackage
{
    public static function flipString(string $string): string
    {
        return strrev($string);
    }

    public static function stringLength(string $string): int
    {
        return mb_strlen($string);
    }
}

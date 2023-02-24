<?php

namespace App\Provider\Elastic\Helper;

class PrintHelper
{
    private const ENCODING_FROM = 'UTF-8';
    private const CYRILLIC_ENCODING_TO = 'ISO-8859-5';

    public static function getCyrillicFormattedStr(string $format, string ...$args): string
    {
        foreach ($args as $i => $iValue) {
            $args[$i] = iconv(self::ENCODING_FROM, self::CYRILLIC_ENCODING_TO, $iValue);
        }

        return iconv(self::CYRILLIC_ENCODING_TO, self::ENCODING_FROM, sprintf($format, ...$args));
    }

}
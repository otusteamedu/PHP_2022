<?php

namespace App\Helper;

use JsonException;

class PrintHelper
{
    private const ENCODING_FROM = 'UTF-8';
    private const CYRILLIC_ENCODING_TO = 'ISO-8859-5';

    /**
     * @throws JsonException
     */
    public function getCyrillicFormattedStr(string $format, mixed ...$args): string
    {
        $vals = [];
        foreach ($args as $iValue) {
            if (is_array($iValue)) {
                $iValue = json_encode($iValue, JSON_THROW_ON_ERROR);
            }
            $vals[] = iconv(self::ENCODING_FROM, self::CYRILLIC_ENCODING_TO, $iValue);
        }

        return iconv(self::CYRILLIC_ENCODING_TO, self::ENCODING_FROM, sprintf($format, ...$vals));
    }

    /**
     * @throws JsonException
     */
    public function printNestedArray(array $array, string $field): void
    {
        $format = $this->buildFormat($array[0][$field]);
        $titleFormat = $this->buildFormat(array_keys($array[0][$field]));
        $this->printArrayTitle($array[0][$field], $titleFormat);

        foreach ($array as $element) {
            echo $this->getCyrillicFormattedStr($format, ...$element[$field]);
        }
    }

    /**
     * @throws JsonException
     */
    public function printArrayTitle(array $array, string $format): void
    {
        echo $this->getCyrillicFormattedStr($format, ...array_keys($array));
    }

    public function buildFormat(array $array): string
    {
        $format = '';
        foreach ($array as $value) {
            $cell = match (gettype($value)) {
                'double' => "| %-5.5f |",
                'integer' => "| %-10d |",
                'string' => "| %-30s |",
                default => "| %-100s |"
            };
            $format .= $cell;
        }

        return $format . PHP_EOL;
    }
}
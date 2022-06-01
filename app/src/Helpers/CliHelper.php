<?php

namespace Nka\OtusSocketChat\Helpers;

class CliHelper
{
    public static function output(string $message): void
    {
        print_r($message . PHP_EOL);
    }

    public static function input(): bool|string
    {
        return trim(fgets(STDIN));
    }

    public static function batchOutput(array $messages): void
    {
        foreach ($messages as $message) {
            self::output((string)$message);
        }
    }
}
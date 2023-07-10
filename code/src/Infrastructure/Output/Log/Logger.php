<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw20\Infrastructure\Output\Log;

class Logger
{
    public static function log($text): void
    {
        $text = date("Y-m-d H:i:s") . " $text\n";

        file_put_contents(
            ROOT . $_ENV["LOG_PATH"],
            $text,
            FILE_APPEND
        );
    }
}
<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw20\Infrastructure\Output\Log;

class ReceiveLogger extends Logger
{
    public static function waiting(): void
    {
        self::log("[*] Waiting for messages");
    }

    public static function received($text): void
    {
        self::log("[x] Received $text");
    }

    public static function done(): void
    {
        self::log("[x] Done");
    }
}
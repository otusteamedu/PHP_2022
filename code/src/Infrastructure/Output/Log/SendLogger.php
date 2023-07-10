<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw20\Infrastructure\Output\Log;

class SendLogger extends Logger
{
    public static function sent($text): void
    {
        self::log("[x] Sent $text");
    }
}
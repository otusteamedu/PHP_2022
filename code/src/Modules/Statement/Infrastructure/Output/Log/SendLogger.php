<?php

declare(strict_types=1);

namespace Nikcrazy37\Hw16\Modules\Statement\Infrastructure\Output\Log;

class SendLogger extends Logger
{
    public static function sent($text): void
    {
        self::log("[x] Sent $text");
    }
}
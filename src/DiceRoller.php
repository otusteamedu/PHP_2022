<?php

declare(strict_types=1);

namespace Olelishna\hw4;

use Exception;

class DiceRoller
{
    public static function roll(int $faces_count = null): int
    {
        if ($faces_count === null || $faces_count === 0) {
            return 1; // critical fumble
        }

        try {
            $result = random_int(1, $faces_count);
        } catch (Exception $e) {
            $result = 1; // critical fumble
        }

        return $result;
    }
}
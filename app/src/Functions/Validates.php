<?php

declare(strict_types=1);

namespace Eliasjump\StringsVerification\Functions\Validates;

function validateBraces(string $input): bool
{
    preg_match_all("/\(|\)/", $input, $out);
    if (!$braces = $out[0]) {
        return true;
    }

    $stack = 0;
    foreach ($braces as $brace) {
        if ($brace == '(') {
            $stack++;
        }
        if ($brace == ')') {
            $stack--;
        }
        if ($stack < 0) {
            return false;
        }
    }

    return $stack == 0;
}

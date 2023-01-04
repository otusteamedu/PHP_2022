<?php

namespace AKhakhanova\Hw4;

use Symfony\Component\HttpFoundation\Request;

class Validator
{
    public function isValidRequest(): bool
    {
        $request = Request::createFromGlobals();
        $string  = $request->query->get('string');
        if (empty($string)) {
            return false;
        }

        if (self::containsUnclosedParenthesis($string, '(', ')')) {
            return false;
        }

        return true;
    }

    public static function containsUnclosedParenthesis(string $value, string $open, string $closed): bool
    {
        if (!str_contains($value, $open) && !str_contains($value, $closed)) {
            return false;
        }

        if (str_contains($value, $open) && !str_contains($value, $closed) || str_contains($value, $closed) && !str_contains($value, $open)) {
            return true;
        }

        while (str_contains($value, $open) && str_contains($value, $closed)) {
            if (strpos($value, $closed) < strpos($value, $open)) {
                return true;
            }

            self::deleteSymbol($value, strpos($value, $open));
            self::deleteSymbol($value, strpos($value, $closed));
        }

        if (str_contains($value, $open) || str_contains($value, $closed)) {
            return true;
        }

        return false;
    }

    public static function deleteSymbol(string &$str, int $position): void
    {
        if ($position === 0) {
            $str = substr($str, 1);

            return;
        }

        if ($position === strlen($str)) {
            $str = substr($str, 0, strlen($str) - 1);

            return;
        }

        $firstPart  = substr($str, 0, $position);
        $secondPart = substr($str, $position + 1);

        $str = $firstPart . $secondPart;
    }
}

<?php

declare(strict_types=1);

namespace Bundle\CheckBracketsBundle;

class CheckBracketsBundle
{
    /**
     * Checks for correct opening/closing brackets
     *
     * @param string $str
     * @return bool
     */
    public static function areBracketsCorrect(string $str): bool
    {
        $str = self::filter($str);

        $count = 1;
        while ($count) {
            $str = preg_replace('/\(\)/', '', $str, -1, $count);
        }

        return strlen($str) === 0;
    }

    /**
     * Returns string only with brackets
     *
     * @param string $str
     * @return string
     */
    public static function filter(string $str): string
    {
        return preg_replace('/[^()]/', '', $str);
    }
}
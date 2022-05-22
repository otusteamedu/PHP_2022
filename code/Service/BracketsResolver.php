<?php

declare(strict_types=1);

namespace App\Service;

class BracketsResolver
{
    public static function isBalanced($str): bool
    {
        $str = self::getBrackets($str);

        return self::areBracketsInOrder($str);
    }

    private static function getBrackets($str): string
    {
        $re = "/[^()\[\]{}]/";

        return preg_replace($re, '', $str);
    }

    private static function areBracketsInOrder($str): bool
    {
        $len = strlen($str);

        $bracket = ["]" => "[", "}" => "{", ")" => "("];

        $openBrackets = [];
        $isClean = true;

        for ($i = 0; $isClean && $i < $len; $i++) {
            if (array_key_exists($str[$i], $bracket)) { // found closing bracket
                $isClean = (array_pop($openBrackets) === $bracket[$str[$i]]);
            } else {
                $openBrackets[] = $str[$i];
            }
        }

        return $isClean && (count($openBrackets) === 0);
    }
}

<?php

declare(strict_types=1);

namespace App\App\Service;

class RandomStringGenerator
{
    private const ENG_ALPHABET = [
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
    ];
    public static function randomEnglishAlphabetSting(int $strLength): string
    {
        if ($strLength < 0) {
            throw new \RuntimeException('Длинна должна быть положительной');
        }

        $result = '';
        while ($strLength !== 0) {
            $result .= self::ENG_ALPHABET[array_rand(self::ENG_ALPHABET)];
            $strLength--;
        }
        return $result;
    }
}
<?php

namespace Ivan\Backend\Actions;

use Exception;

class VerifyAction
{
    public const BRACKET_LEFT = '(';
    public const  BRACKET_RIGHT = ')';

    /**
     * @throws Exception
     */
    public function run(string $string): void
    {
        if (!str_contains($string, self::BRACKET_LEFT)) {
            throw new Exception('Некорректный ввод [1]');
        }
        if (preg_match('/\)\(/', $string) && mb_strlen($string) === 2) {
            throw new Exception('Некорректный ввод [2]');
        }

        $counter = 0;

        foreach (str_split($string) as $value) {
            if ($value === self::BRACKET_RIGHT) {
                $counter++;
            }
            if ($value === self::BRACKET_LEFT) {
                $counter--;
            }
        }
        if ($counter % 2 !== 0) {
            throw new Exception('Некорректный ввод [3]');
        }
    }
}

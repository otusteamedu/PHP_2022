<?php

namespace letter_combinations_of_a_phone_number;

/**
 *  Сложность экспоненциальная,  ~O(3^n)
 *   3 - среднее число символов  на каждую цифру
 *
 *  По памяти также экспонента  ~O(3^n), при увеличении вводных цифр ответный массив растёт по экспоненте
 *
 *  https://leetcode.com/problems/letter-combinations-of-a-phone-number/submissions/1066889388/
 */
class Solution
{
    private const KEYBOARD = [
        "2" => "abc",
        "3" => "def",
        "4" => "ghi",
        "5" => "jkl",
        "6" => "mno",
        "7" => "pqrs",
        "8" => "tuv",
        "9" => "wxyz"
    ];
    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations($digits)
    {
        $strlen = strlen($digits);

        if ($strlen === 0) {
            return [];
        }
        $result = [''];
        for ($i = 0; $i < $strlen; $i++) {
            $line = self::KEYBOARD[$digits[$i]];
            $prevResult = [];
            $lineLen = strlen($line);
            for ($j = 0; $j < $lineLen; $j++) {
                foreach ($result as $str) {
                    $prevResult[] = $str . $line[$j];
                }
            }
            $result = $prevResult;
        }

        return $result;
    }
}

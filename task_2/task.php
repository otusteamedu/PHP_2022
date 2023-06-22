<?php

class Solution {
    private const LETTERS = [
        2 => ["a", "b", "c"],
        3 => ["d", "e", "f"],
        4 => ["g", "h", "i"],
        5 => ["j", "k", "l"],
        6 => ["m", "n", "o"],
        7 => ["p", "q", "r", "s"],
        8 => ["t", "u", "v"],
        9 => ["w", "x", "y", "z"],
    ];

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        if (!strlen($digits)) {
            return [];
        }

        $res = [];

        $this->combineLetters($res, $digits);

        return $res;
    }

    private function combineLetters(array &$res, string $digits, int $cursor = 0, string $combine = "") {
        if (strlen($digits) === $cursor) {
            $res[] = $combine;
            return false;
        }

        $count = count(self::LETTERS[$digits[$cursor]]);

        for($i = 0; $i < $count; $i++) {
            $letter = self::LETTERS[$digits[$cursor]][$i];

            $this->combineLetters($res, $digits, $cursor + 1, $combine . $letter);
        }
    }
}
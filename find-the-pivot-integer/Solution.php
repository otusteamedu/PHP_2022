<?php

namespace find_the_pivot_integer;

/**
 *  Сложность линейная O(n)
 *
 *  по памяти константная O(1)
 *
 *  https://leetcode.com/problems/find-the-pivot-integer/submissions/1065225100/
 */

class Solution
{
    /**
     * @param Integer $n
     * @return Integer
     */
    public function pivotInteger($n)
    {
        if ($n === 1) {
            return 1;
        }

        for ($i = 2; $i < $n; $i++) {
            if ($this->arithmeticProgressionSum(1, $i - 1) === $this->arithmeticProgressionSum($i + 1, $n)) {
                return $i;
            }
        }

        return -1;
    }

    private function arithmeticProgressionSum(int $n, int $m): int
    {
        return 0.5 * ($m + $n) * ($m - $n + 1);
    }
}

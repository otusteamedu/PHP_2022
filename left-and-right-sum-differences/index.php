<?php

/**
 *  Сложность линейная O(n + n-1 + n-1) = O(n)
 *   три цикла по n, n-1, n-1       ~3n, константу отбрасываем
 *
 *  по памяти также O(n)
 *
 *  https://leetcode.com/problems/left-and-right-sum-differences/submissions/1065150987/
 */

class Solution
{

    /**
     * @param Integer[] $nums
     * @return Integer[]
     */
    function leftRightDifference($nums)
    {
        $answer = [];

        $leftSum = $this->leftSum($nums);
        $rightSum = $this->rightSum($nums);

        foreach ($nums as $key => $num) {
            $answer[] = abs($leftSum[$key] - $rightSum[$key]);
        }

        return $answer;
    }

    private function leftSum(array $nums): array
    {
        $result = [];
        $length = count($nums);
        $result[] = 0;

        if ($length < 2) {
            return $result;
        }

        for ($i = 1; $i < $length; $i++) {
            $result[$i] = $result[$i - 1] + $nums[$i - 1];
        }

        return $result;
    }

    private function rightSum(array $nums): array
    {
        $result = [];
        $length = count($nums);
        $result[$length - 1] = 0;

        if ($length < 2) {
            return $result;
        }

        for ($i = $length - 2; $i >= 0; $i--) {
            $result[$i] = $result[$i + 1] + $nums[$i + 1];
        }

        return $result;
    }
}

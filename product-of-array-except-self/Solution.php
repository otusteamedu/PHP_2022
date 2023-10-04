<?php

namespace  product_of_array_except_self;

/**
 *  Сложность линейная O(n + n-1 + n-1) = O(n)
 *   три цикла по n, n-1, n-1       ~3n, константу отбрасываем
 *
 *  по памяти также O(n)
 *
 *  https://leetcode.com/problems/product-of-array-except-self/submissions/1065161879/
 */

class Solution
{
    /**
     * @param  Integer[] $nums
     * @return Integer[]
     */
    public function productExceptSelf($nums)
    {
        $answer = [];

        $leftProds = $this->leftProds($nums);
        $rightProds = $this->rightProds($nums);

        foreach ($nums as $key => $num) {
            $answer[] = $leftProds[$key] * $rightProds[$key];
        }

        return $answer;
    }

    private function leftProds(array $nums): array
    {
        $result = [];
        $length = count($nums);
        $result[] = 1;

        for ($i = 1; $i < $length; $i++) {
            $result[$i] = $result[$i - 1] * $nums[$i - 1];
        }

        return $result;
    }

    private function rightProds(array $nums): array
    {
        $result = [];
        $length = count($nums);
        $result[$length - 1] = 1;

        for ($i = $length - 2; $i >= 0; $i--) {
            $result[$i] = $result[$i + 1] * $nums[$i + 1];
        }

        return $result;
    }
}

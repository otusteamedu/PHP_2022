<?php

namespace linked_list_cycle;

/**
 *  Сложность линейная O(n)
 *
 *  по памяти линейная O(n), где n - кол-во узлов в списке
 *
 *  https://leetcode.com/problems/linked-list-cycle/submissions/1065855879/
 */
class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle($head)
    {
        $hash = [];
        if ($head) {
            $hash[spl_object_id($head)] = true;
        }

        while ($head && $head->next) {
            $head = $head->next;
            if (isset($hash[spl_object_id($head)])) {
                return true;
            }
            if ($head) {
                $hash[spl_object_id($head)] = true;
            }
        }

        return false;
    }
}

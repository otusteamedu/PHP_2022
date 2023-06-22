<?php

class ListNode {
    public $val = 0;
    public $next = null;
    function __construct($val) { $this->val = $val; }
}

class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head)
    {
        $tmpHead = $head;

        while ($tmpHead->next) {
            if ($tmpHead->val === null) {
                return true;
            }
            $tmpHead->val = null;
            $tmpHead = $tmpHead->next;
        }

        return false;
    }
}
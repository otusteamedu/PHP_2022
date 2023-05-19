/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val = 0, $next = null) {
 *         $this->val = $val;
 *         $this->next = $next;
 *     }
 * }
 */
class Solution {

    private $_result_head = null;
    private $_result_tail = null;

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    function mergeTwoLists($list1, $list2) {
        while ($list1 !== null) {
            while ($list2 !== null && $list2->val < $list1->val) {
                $list2 = $this->_solution_step($list2);
            }
            $list1 = $this->_solution_step($list1);
        }
        while ($list2 !== null) {
            $list2 = $this->_solution_step($list2);
        }
        return $this->_result_head;
    }

    /**
     * @param ListNode $add_node
     * @return ListNode
     */
    private function _solution_step(ListNode $add_node): ?ListNode {
        $this->_update_solution(new ListNode($add_node->val));
        $new_tail = $add_node->next;
        return $new_tail;
    }

    /**
     * @param ListNode $add_node
     * @return void
     */
    private function _update_solution(ListNode $add_node): void {
        $this->_result_tail = self::add_node_to_list_tail($this->_result_tail, $add_node);
        $this->_result_head = self::set_list_head($this->_result_head, $add_node);
    }

    /**
     * @param ListNode $list_tail
     * @param ListNode $add_node
     * @return ListNode
     */
    private static function add_node_to_list_tail(?ListNode $list_tail, ListNode $add_node): ListNode {
        if ($list_tail !== null) {
            $list_tail->next = $add_node;
        }
        return $add_node;
    }

    /**
     * @param ListNode $list_head
     * @param ListNode $list_tail
     * @return ListNode
     */
    private static function set_list_head(?ListNode $list_head, ListNode $list_tail): ListNode {
        if ($list_head === null) {
            $list_head = $list_tail;
        }
        return $list_head;
    }

}
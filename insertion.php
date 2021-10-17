<?php
require_once('./common.php');

class InsertionSorter extends BaseSorter {
    public function __construct() {
        parent::__construct("Insertion");
    }

    public function sort(array &$nums) : void {
        $count = sizeof($nums);
        if ($count < 2) {
            return;
        }
        for ($i = 1; $i < $count; ++$i) {
            [ $value, $j ] = [ $nums[$i], $i - 1 ];
            for (; $j >= 0 && $nums[$j] > $value; --$j) {
                $nums[$j + 1] = $nums[$j];
            }
            $must_move_value = $nums[$i] != $value;
            if ($must_move_value) {
                // Have to compensate for the last decrement of j
                $nums[$j + 1] = $value;
            }
        }
    }
}
?>
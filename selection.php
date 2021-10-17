<?php
require_once('./common.php');

class SelectionSorter extends BaseSorter {
    public function __construct() {
        parent::__construct("Selection");
    }

    public function sort(array &$nums) : void {
        $count = sizeof($nums);
        if ($count < 2) {
            return;
        }
        for ($i = 0; $i < $count - 1; ++$i) {
            [ $min, $swap_with ] = [ $nums[$i], 0 ];
            for ($j = $i + 1; $j < $count; ++$j) {
                if ($nums[$j] < $min) {
                    [ $min, $swap_with ] = [ $nums[$j], $j ];
                }
            }
            if ($swap_with > 0) {
                swapValuesIn($nums, $i, $swap_with);
            }
        }
    }
}
?>
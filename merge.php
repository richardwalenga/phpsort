<?php
require_once('./common.php');

class MergeSorter extends BaseSorter {
    private BaseSorter $small_array_sorter;
    public function __construct(BaseSorter $small_array_sorter) {
        parent::__construct("Merge");
        $this->small_array_sorter = $small_array_sorter;
    }

    public function sort(array &$nums) : void {
        $count = sizeof($nums);
        if ($count < 10) {
            $this->small_array_sorter->sort($nums);
            return;
        }
        $mid = floor($count / 2);
        [ $first, $second ] = [ array_slice($nums, 0, $mid), array_slice($nums, $mid) ];
        [ $first_count, $second_count ] = [ sizeof($first), sizeof($second) ];
        $this->sort($first);
        $this->sort($second);
        for ($i = 0; $i < $count; ++$i) {
            $first_index = $second_index = 0;
            [ $can_take_first, $can_take_second ] = [ $first_index < $first_count, $second_index < $second_count ];
            if ($can_take_first and (!$can_take_second || $first[$first_index] <= $second[$second_index])) {
                $nums[$i] = $first[$first_index];
                if ($first_index < $first_count) {
                    ++$first_index;
                }
            }
            else {
                $nums[$i] = $second[$second_index];
                if ($second_index < $second_count) {
                    ++$second_index;
                }
            }              
        }
    }
}
?>
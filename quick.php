<?php
require_once('./common.php');

class QuickSorter extends BaseSorter {
    public function __construct() {
        parent::__construct("Quick");
    }

    private function sortBetweenIndexes(array &$nums, int $low, int $high) : void {
        if ($low < $high) {
            $pivot_index = $this->partition($nums, $low, $high);
            $this->sortBetweenIndexes($nums, $low, $pivot_index-1);
            $this->sortBetweenIndexes($nums, $pivot_index+1, $high);
        }
    }

    // Organizes the values between the high and low indexes where the
    // chosen pivot is moved to a new index where all values greater than
    // the pivot are to its right. The new index for the pivot is returned.
    private function partition(array &$nums, int $low, int $high) : int {
        $pivot = $nums[$high];
        //initialize the index below low because the index is guaranteed
        // to be incremented before the pivot is moved to its new home.
        $new_pivot_index = $low - 1;
        for ($i = $low; $i < $high; ++$i) {
            if ($nums[$i] <= $pivot) {
                swapValuesIn($nums, ++$new_pivot_index, $i);
            }
        }
        // There will always be at least one swap call since if this is the 
        // first time, it means every value checked is greater than the pivot.
        swapValuesIn($nums, ++$new_pivot_index, $high);
        return $new_pivot_index;
    }

    public function sort(array &$nums) : void {
        $this->sortBetweenIndexes($nums, 0, sizeof($nums) - 1);
    }
}
?>
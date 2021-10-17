<?php
require_once('./common.php');

class BubbleSorter extends BaseSorter {
    public function __construct(string $name = "Bubble") {
        parent::__construct($name);
    }

    public function sort(array &$nums) : void {
        $count = sizeof($nums);
        if ($count < 2) {
            return;
        }
        while ($this->ltrSort($nums, $count));
    }

    protected function ltrSort(array &$nums, int $count): bool {
        $swapped = false;
        for ($i = 1; $i < $count; ++$i) {
            if ($nums[$i - 1] > $nums[$i]) {
                swapValuesIn($nums, $i - 1, $i);
                $swapped = true;
            }
        }
        return $swapped;
    }
}

class CocktailShakerSorter extends BubbleSorter {
    // By applying a bitmask of 1 less than a power of 2, I can cleanly
    // alternate sorting left to right followed by right to left.
    const BITMASK = 1;
    public function __construct() {
        parent::__construct("Cocktail Shaker");
    }

    public function sort(array &$nums) : void {
        $count = sizeof($nums);
        if ($count < 2) {
            return;
        }
        for ($i = 0, $swapped = true; $swapped; $i = ($i + 1) & self::BITMASK) {
            $swapped = $i == 0
                ? $this->ltrSort($nums, $count)
                : $this->rtlSort($nums, $count);
        }
    }

    protected function rtlSort(array &$nums, int $count): bool {
        $swapped = false;
        for ($i = $count - 1; $i > 0; --$i) {
            if ($nums[$i] < $nums[$i - 1]) {
                swapValuesIn($nums, $i - 1, $i);
                $swapped = true;
            }
        }
        return $swapped;
    }
}
?>
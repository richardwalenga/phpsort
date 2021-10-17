<?php
require_once('./bubble.php');
require_once('./heap.php');
require_once('./insertion.php');
require_once('./selection.php');
require_once('./merge.php');
require_once('./quick.php');

function isSorted(array &$nums): bool {
    for ($i = 0; $i < sizeof($nums) - 1; ++$i) {
        if ($nums[$i + 1] < $nums[$i]) {
            return false;
        }
    }
    return true;
}

class SimpleStopWatch {
    private $started;
    public function start() {
        $this->started = hrtime(true);
    }

    public function getElapsedMilliseconds() : int {
        return floor((hrtime(true) - $this->started)/1e+6);
    }
}

$to_sort = array();
for ($i = 0; $i < 20000; ++$i) {
    $to_sort[$i] = random_int(0, 100000);
}

$insertionSorter = new InsertionSorter();
$sorters = [
    new BubbleSorter(),
    new CocktailShakerSorter(),
    $insertionSorter,
    new SelectionSorter(),
    new HeapSorter($insertionSorter),
    new MergeSorter($insertionSorter),
    new QuickSorter()
];
$watch = new SimpleStopWatch;
foreach ($sorters as $sorter) {
    $nums = array_slice($to_sort, 0);
    $watch->start();
    $sorter->sort($nums);
    $milliseconds = $watch->getElapsedMilliseconds();
    $sorted = isSorted($nums) ? "true" : "false";
    echo "{$sorter->getName()} Sorter finished in $milliseconds milliseconds. Sorted: $sorted\n";
}
?>
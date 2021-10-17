<?php
function swapValuesIn(array &$ary, int $x, int $y): void {
    if ($x == $y) {
        return;
    }
    [ $ary[$x], $ary[$y] ] = [ $ary[$y], $ary[$x] ];
}

abstract class BaseSorter {
    private string $name;
    public function __construct(string $name) {
        $this->name = $name;
    }

    public function getName(): string { return $this->name; }

    abstract public function sort(array &$nums) : void;
}
?>
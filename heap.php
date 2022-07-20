<?php
require_once('./common.php');

abstract class HeapifyDirection {
    const DOWN = 0;
    const UP = 1;
}

class EmptyHeapError extends Exception {}

class HeapCapacityTooSmallError extends Exception {}

class HeapNode {
    private Heap $heap;
    private int $index;
    private bool $is_root;
    public function __construct(Heap $heap, int $index) {
        $this->heap = $heap;
        $this->index = $index;
        $this->is_root = $index == Heap::ROOT_INDEX;
    }

    public function getValue() : int {
        return $this->heap->storage[$this->index];
    }

    public function setValue(int $new_val) : void {
        $this->heap->storage[$this->index] = $new_val;
    }

    public function heapifyDown() : void {
        [ $left, $right ] = [ $this->getLeft(), $this->getRight() ];
        if ($left == null && $right == null) {
            return;
        }
        $node = $right;
        if ($left != null && $right != null) {
            if ($this->heap->compare($left->getValue(), $right->getValue())) {
                $node = $left;
            }
        }
        elseif ($left != null) {
            $node = $left;
        }
        $this->trySwapValueWith($node, HeapifyDirection::DOWN);
    }

    public function heapifyUp() : void {
        $parent = $this->getParent();
        if ($parent != null) {
            $this->trySwapValueWith($parent, HeapifyDirection::UP);
        }
    }

    private function fromIndex(int $index) : ?HeapNode {
        return $this->heap->isOutOfRange($index)
            ? null
            : new HeapNode($this->heap, $index);
    }

    public function getLeft() : ?HeapNode {
        return $this->fromIndex(2 * $this->index);
    }

    public function getRight() : ?HeapNode {
        return $this->fromIndex(2 * $this->index + 1);
    }

    public function getParent() : ?HeapNode {
        return $this->is_root
            ? null
            : new HeapNode($this->heap, floor($this->index / 2));
    }

    private function trySwapValueWith(?HeapNode $other, int $direction) : void {
        if ($other == null) {
            return;
        }        
        [ $val, $other_val ] = [ $this->getValue(), $other->getValue() ];
        if ($direction == HeapifyDirection::DOWN && $this->heap->compare($other_val, $val)) {
            $this->setValue($other_val);
            $other->setValue($val);
            $other->heapifyDown();
        }
        elseif ($direction == HeapifyDirection::UP && $this->heap->compare($val, $other_val)) {
            $this->setValue($other_val);
            $other->setValue($val);
            $other->heapifyUp();
        }
    }
}

class Heap {
    public const ROOT_INDEX = 1;
    private bool $is_min;
    public array $storage;
    private int $size;
    public function __construct(bool $is_min=true, int $capacity=30) {
        if ($capacity < 5) {
            throw new HeapCapacityTooSmallError();
        }
        $this->is_min = $is_min;
        $this->storage = array_fill(0, $capacity+1, null);
        $this->size = 0;
    }

    public function compare(int $x, int $y) : bool {
        return $this->is_min ? $x < $y : $x > $y;
    }

    public function isOutOfRange(int $index) : bool {
        return $index > $this->size;
    }

    public function peek() {
        $this->storage[self::ROOT_INDEX] ?? NAN;
    }

    public function store(int $num) : void {
        $this->storage[++$this->size] = $num;
        $setting_root = $this->size == self::ROOT_INDEX;
        if (!$setting_root) {
            (new HeapNode($this, $this->size))->heapifyUp();
        }
    }

    public function take() {
        if ($this->size == 0) {
            throw new EmptyHeapError();
        }
        // Choosing the last value to temporarily put in the root is
        // arbitrary but requires no extra processing time other than
        // what it takes to let it settle into its new position
        $taken = $this->storage[self::ROOT_INDEX];
        $this->storage[self::ROOT_INDEX] = $this->storage[$this->size--];
        if ($this->size > 1) {
            (new HeapNode($this, self::ROOT_INDEX))->heapifyDown();
        }
        return $taken;
    }
}

class HeapSorter extends BaseSorter {
    private BaseSorter $small_array_sorter;
    public function __construct(BaseSorter $small_array_sorter) {
        parent::__construct('Heap');
        $this->small_array_sorter = $small_array_sorter;
    }
    
    public function sort(array &$nums) : void {
        $count = sizeof($nums);
        if ($count < 10) {
            $this->small_array_sorter->sort($nums);
            return;
        }
        $heap = new Heap(capacity: $count);
        foreach ($nums as $num) {
            $heap->store($num);
        }
        for ($i = 0; $i < $count; ++$i) {
            $nums[$i] = $heap->take();
        }
    }
}
?>
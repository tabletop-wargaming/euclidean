<?php

namespace TabletopWargaming\Euclidean\Distance\Range;

use \TabletopWargaming\Common\Interfaces\Renderable;
use \TabletopWargaming\Euclidean\Distance\Range;
use \TabletopWargaming\Euclidean\Distance\Length;

class Aggregate implements Range, Renderable
{
    use \TabletopWargaming\Euclidean\Distance\Range\RangeTrait;

    private $ranges = array();

    public function __construct($ranges)
    {
        foreach ($ranges as $range) {
            $this->addRange($range);
        }
    }

    public function getStart()
    {
        return min($this->ranges)->getStart();
    }

    private function sort(Range $first, Range $second)
    {
        $firstStart = $first->getStart();
        $secondStart = $second->getStart();
        return $firstStart->compare($secondStart);
    }

    private function addRange(Range $range)
    {
        $ranges = $this->ranges;
        foreach ($ranges as $band) {
            if ($range->overlaps($band)) {
                throw new \OutOfBoundsException("Ranges cannot overlap, ($band) ($range)");
            }
        }
        $ranges[] = $range;
        @usort($ranges, array($this, 'sort'));
        $this->ranges = $ranges;
    }

    public function getEnd()
    {
        return end($this->ranges)->getEnd();
    }

    public function in(Length $measurement)
    {
        foreach ($this->ranges as $range) {
            if ($range->in($measurement)) {
                return $range;
            }
        }
    }
}


<?php

namespace TabletopWargaming\Euclidean\Distance\Range;

use \TabletopWargaming\Common\Interfaces\Comparable;
use \TabletopWargaming\Common\Interfaces\Named as NamedInterface;
use \TabletopWargaming\Euclidean\Distance\Length;
use \TabletopWargaming\Euclidean\Distance\Range;

class Named implements Range, NamedInterface
{
    use \TabletopWargaming\Common\Traits\Nameable;
    use \TabletopWargaming\Euclidean\Distance\Range\RangeTrait;

    private $range;

    public function __construct(Range $range)
    {
        $this->range = $range;
    }

    public function getStart()
    {
        return $this->getRange()->getStart();
    }

    public function getEnd()
    {
        return $this->getRange()->getEnd();
    }

    public function in(Length $measurement)
    {
        $compare = $this->compare($measurement);
        if (Comparable::EQUAL_TO === $compare) {
            return $this;
        }
    }

    private function getRange()
    {
        return $this->range;
    }
}

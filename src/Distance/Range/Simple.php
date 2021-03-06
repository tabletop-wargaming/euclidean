<?php

namespace TabletopWargaming\Euclidean\Distance\Range;

use \TabletopWargaming\Common\Interfaces\Comparable;
use TabletopWargaming\Common\Interfaces\Renderable;
use \TabletopWargaming\Euclidean\Distance\Length;
use \TabletopWargaming\Euclidean\Distance\Range;

class Simple implements Range, Renderable
{
    use \TabletopWargaming\Euclidean\Distance\Range\RangeTrait;

    private $start;

    private $end;

    public function __construct(Length $start, Length $end)
    {
        if ($start->isGreaterThan($end)) {
            throw new \LengthException('Start of the range cannot be larger than the end');
        }
        $this->start = $start;
        $this->end = $end;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function in(Length $measurement)
    {
        $compare = $this->compare($measurement);
        if (Comparable::EQUAL_TO === $compare) {
            return $this;
        }
    }
}

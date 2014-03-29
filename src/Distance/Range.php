<?php

namespace TabletopWargaming\Euclidean\Distance;

use \TabletopWargaming\Euclidean\Distance\Length;

interface Range
{
    public function getStart();

    public function getEnd();

    public function isInfinite();

    public function in(Length $length);

    public function overlaps(Range $range);
}

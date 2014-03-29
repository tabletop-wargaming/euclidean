<?php

namespace TabletopWargaming\Euclidean\Distance;

interface Length
{
    public function getSystem();

    public function getDistance();

    public function toBase();

    public function isInfinite();
}


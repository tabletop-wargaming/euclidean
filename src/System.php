<?php

namespace TabletopWargaming\Euclidean;

interface System
{
    public function getName();

    public function getUnit();

    public function toBase($distance);

    public function toUnit($distance);
}

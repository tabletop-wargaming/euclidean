<?php

namespace TabletopWargaming\Euclidean\System\Distance;

use \TabletopWargaming\Euclidean\System;
use \TabletopWargaming\Euclidean\System\Distance;

class Simple implements Distance, System
{
    use \TabletopWargaming\Common\Traits\Nameable;

    private $unit;

    private $base;

    private $format;

    public function __construct($name, $unit, $base, $format = null)
    {
        $this->name     = $name;
        $this->unit     = $unit;
        $this->base     = $base;
        $this->format   = (string) $format;
    }

    public function __toString()
    {
        return (string) $this->getUnit();
    }

    public function getUnit()
    {
        return $this->unit;
    }

    public function render($distance)
    {
        return vsprintf($this->format, $distance);
    }

    public function toBase($distance)
    {
        return (double) bcmul($distance, $this->base);
    }

    public function toUnit($distance)
    {
        return (double) bcdiv($distance, $this->base);
    }
}

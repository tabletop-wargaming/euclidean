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
        $this->base     = (double) $base;
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

    public function getBase()
    {
        return $this->base;
    }

    public function render($distance)
    {
        return vsprintf($this->format, $distance);
    }

    public function toBase($distance, $scale = 0)
    {
        return (int) bcmul($this->getBase(), $distance);
    }

    public function toUnit($base, $scale = 0)
    {
        $unit = (double) bcdiv($base, $this->getBase(), $scale);
        var_dump("unit was $unit, base was $base");
        return $unit;
    }
}

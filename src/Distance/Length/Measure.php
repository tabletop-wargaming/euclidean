<?php

namespace TabletopWargaming\Euclidean\Distance\Length;

use \TabletopWargaming\Common\Interfaces\Comparable;
use \TabletopWargaming\Common\Interfaces\Renderable;
use \TabletopWargaming\Euclidean\Distance\Length;
use \TabletopWargaming\Euclidean\System\Distance;
use TabletopWargaming\Euclidean\System;

class Measure implements Length, Renderable
{
    const SCALE = 2;

    private $system;

    private $distance;

    private $delta;

    public function __construct($distance, Distance $system, $scale = self::SCALE)
    {
        $this->distance = (double) $distance;
        $this->system = $system;
        $this->scale = $scale;
    }

    public function __toString()
    {
        return (string) $this->render();
    }

    public function render()
    {
        return $this->getSystem()->render($this->getDistance());
    }

    public function getSystem()
    {
        return $this->system;
    }

    public function getDistance()
    {
        return $this->distance;
    }

    public function getScale()
    {
        return $this->scale;
    }

    public function add(Length $length)
    {
        $diff = bcadd($this->toBase(), $length->toBase(), $this->getScale());
        return $this->fromBase($diff, $this->getSystem());
    }

    public function subtract(Length $length)
    {
        $diff = bcsub($this->toBase(), $length->toBase(), $this->getScale());
        return $this->fromBase($diff, $this->getSystem());
    }

    public function divide($divisor)
    {
        $diff = bcdiv($this->toBase(), $divisor, $this->getScale());
        return $this->fromBase($diff, $this->getSystem());
    }

    public function multiply($multiplier)
    {
        $diff = bcmul($this->toBase(), $multiplier, $this->getScale());
        return $this->fromBase($diff, $this->getSystem());
    }

    public function convertTo(Distance $system)
    {
        $distance = $system->toBase($this->getDistance());
        return $this->fromBase($distance, $system);
    }

    public function toBase()
    {
        return ($this->isInfinite()) ? INF : $this->getSystem()->toBase($this->getDistance());
    }

    public function isInfinite()
    {
        return (INF == $this->distance);
    }

    public function isGreaterThan(Length $length)
    {
        return ($this->compare($length) === Comparable::GREATER_THAN);
    }

    public function isLessThan(Length $length)
    {
        return ($this->compare($length) === Comparable::LESS_THAN);
    }

    public function isEqualTo(Length $length)
    {
        return ($this->compare($length) === Comparable::EQUAL_TO);
    }

    public function compare(Length $length)
    {
        return bccomp($this->toBase(), $length->toBase(), $this->getScale());
    }

    private function fromBase($diff, Distance $system)
    {
        $scale = $this->getScale();
        $unit = $system->toUnit($diff);
        return new self($unit, $system, $scale);
    }
}

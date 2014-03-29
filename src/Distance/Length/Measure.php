<?php

namespace TabletopWargaming\Euclidean\Distance\Length;

use \TabletopWargaming\Common\Interfaces\Comparable;
use \TabletopWargaming\Common\Interfaces\Renderable;
use \TabletopWargaming\Euclidean\Distance\Length;
use \TabletopWargaming\Euclidean\System\Distance;

class Measure implements Length, Renderable
{
    const DELTA = 0.00001;

    private $system;

    private $distance;

    private $delta;

    public function __construct($distance, Distance $system, $delta = self::DELTA)
    {
        $this->distance = $distance;
        $this->system = $system;
        $this->delta = (double) $delta;
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

    public function add(Length $length)
    {
        $diff = $this->toBase() + $length->toBase();
        $distance = $this->getSystem()->toUnit($diff);
        return new self($distance, $this->getSystem());
    }

    public function subtract(Length $length)
    {
        $diff = $this->toBase() - $length->toBase();
        $distance = $this->getSystem()->toUnit($diff);
        return new self($distance, $this->getSystem());
    }

    public function convertTo(Distance $system)
    {
        $distance = $this->system->toBase($this->distance);
        $unit = $system->toUnit($distance);
        return new self($unit, $system);
    }

    public function toBase()
    {
        return ($this->isInfinite()) ? INF : $this->system->toBase($this->distance);
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
        return bccomp($this->toBase(), $length->toBase());
    }
}

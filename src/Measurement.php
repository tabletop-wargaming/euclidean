<?php

namespace TabletopWargaming\Euclidean;

use \TabletopWargaming\Euclidean\System;

interface Measurement
{
    public function isGreaterThan(Measurement $measurement);

    public function isLessThan(Measurement $measurement);

    public function isEqualTo(Measurement $measurement);

    public function compare(Measurement $measurement);

    public function add(Measurement $measurement);

    public function subtract(Measurement $measurement);

    public function convertTo(System $system);
    
    public function getSystem();
}

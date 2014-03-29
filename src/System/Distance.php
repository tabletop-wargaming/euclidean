<?php

namespace TabletopWargaming\Euclidean\System;

interface Distance
{
    const IMPERIAL          = 'Imperial';
    const METRIC            = 'Metric';

    const INCHES            = 'inches';
    const CM                = 'centimetres';

    const FORMAT_IMPERIAL   = '%d"';

    const FORMAT_METRIC     = '%dcm';

    const INCH_MICRO        = 25400; // number of μm in an inch

    const CM_MICRO          = 10000; // number of μm in a cm
}

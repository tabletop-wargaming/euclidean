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

    const INCH_MM        = 25.4; // number of mm in an inch

    const CM_MM          = 10; // number of mm in a cm
}

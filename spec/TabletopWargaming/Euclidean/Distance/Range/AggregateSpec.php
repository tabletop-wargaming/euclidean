<?php

namespace spec\TabletopWargaming\Euclidean\Distance\Range;

use \PhpSpec\ObjectBehavior;
use \Prophecy\Argument;
use \TabletopWargaming\Euclidean\Distance\Length\Measure;
use \TabletopWargaming\Euclidean\System\Distance;
use \TabletopWargaming\Euclidean\System\Distance\Simple as SimpleDistance;
use \TabletopWargaming\Euclidean\Distance\Range\Simple;

class AggregateSpec extends ObjectBehavior
{
    public function let()
    {
        $system = new SimpleDistance(
            Distance::IMPERIAL,
            Distance::INCHES,
            Distance::INCH_MICRO,
            Distance::FORMAT_IMPERIAL
        );

        for ($i=0; $i<48; $i+=8) {
            $start = new Measure($i, $system);
            $end = new Measure($i + 8, $system);
            $ranges[] = new Simple($start, $end);
        }
        shuffle($ranges);
        $this->beConstructedWith($ranges);
    }

    function it_gives_me_the_start()
    {
        $system = new SimpleDistance(
            Distance::IMPERIAL,
            Distance::INCHES,
            Distance::INCH_MICRO,
            Distance::FORMAT_IMPERIAL
        );
        $start = new Measure(0, $system);
        $this->getStart()->shouldBeLike($start);
    }

    function it_gives_me_the_end_measurement()
    {
        $system = new SimpleDistance(
            Distance::IMPERIAL,
            Distance::INCHES,
            Distance::INCH_MICRO,
            Distance::FORMAT_IMPERIAL
        );
        $end = new Measure(48, $system);
        $this->getEnd()->shouldBeLike($end);
    }

    function it_gives_me_the_range_a_measurement_is_in()
    {
        $system = new SimpleDistance(
            Distance::IMPERIAL,
            Distance::INCHES,
            Distance::INCH_MICRO,
            Distance::FORMAT_IMPERIAL
        );
        $in = new Measure(47, $system);
        $start = new Measure(40, $system);
        $end = new Measure(48, $system);
        $range = new Simple($start, $end);
        $this->in($in)->shouldBeLike($range);
    }
}

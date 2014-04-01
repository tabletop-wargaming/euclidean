<?php

namespace spec\TabletopWargaming\Euclidean\Distance\Range;

use \PhpSpec\ObjectBehavior;
use \Prophecy\Argument;
use \TabletopWargaming\Euclidean\Distance\Length\Measure;
use \TabletopWargaming\Euclidean\System\Distance;
use \TabletopWargaming\Euclidean\System\Distance\Simple as SimpleDistance;
use \TabletopWargaming\Euclidean\Distance\Range\Simple as SimpleRange;

class SimpleSpec extends ObjectBehavior
{
    public function let($start, $end, $in)
    {
        $start->beADoubleOf('TabletopWargaming\Euclidean\Distance\Length\Measure');
        $end->beADoubleOf('TabletopWargaming\Euclidean\Distance\Length\Measure');
        $in->beADoubleOf('TabletopWargaming\Euclidean\Distance\Length\Measure');
        $start->isGreaterThan($end)->willReturn(false);
        $this->beConstructedWith($start, $end);
    }

    function it_is_to_strinagable()
    {
        $system = new SimpleDistance(
            Distance::IMPERIAL,
            Distance::INCHES,
            Distance::INCH_MM,
            Distance::FORMAT_IMPERIAL
        );
        $start = new Measure(0, $system);
        $end = new Measure(8, $system);

        $this->beConstructedWith($start, $end);
        $this->__toString()->shouldReturn('0-8');
    }

    function it_should_return_the_start_length($start)
    {
        $this->getStart()->shouldReturn($start);
    }

    function it_should_return_the_end_Length($end)
    {
        $this->getEnd()->shouldReturn($end);
    }

    function it_should_not_allow_a_start_value_higher_than_the_end_value(
        $start,
        $end
    )
    {
        $start->isGreaterThan($end)->willReturn(true);
        $this->shouldThrow('\LengthException')->during('__construct', array($start, $end));
    }

    function it_should_return_itself_if_it_is_in_range(
        Measure $start,
        Measure $end,
        Measure $in
    )
    {
        $in->isLessThan($start)->willReturn(false);
        $in->isLessThan($end)->willReturn(true);
        $this->in($in)->shouldReturn($this->getWrappedObject());
    }

    function it_should_return_null_if_out_of_range(
        $start,
        $end,
        $in
    )
    {
        $in->isLessThan($start)->willReturn(false);
        $in->isLessThan($end)->willReturn(false);;
        $this->in($in)->shouldReturn(null);
    }

    function it_can_be_infinite(
        $end
    ) {
        $end->isInfinite()->willReturn(true);
        $this->isInfinite()->shouldReturn(true);
    }

    function it_can_tell_me_if_it_overlaps_another_range($start, SimpleRange $range)
    {
        $range->in($start)->willReturn(true);
        $this->overlaps($range)->shouldReturn(true);
    }
}

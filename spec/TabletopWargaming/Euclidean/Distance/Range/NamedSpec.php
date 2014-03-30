<?php

namespace spec\TabletopWargaming\Euclidean\Distance\Range;

use \PhpSpec\ObjectBehavior;
use \Prophecy\Argument;
use TabletopWargaming\Common\Interfaces\Comparable;
use \TabletopWargaming\Euclidean\Distance\Length\Measure;
use \TabletopWargaming\Euclidean\System\Distance;
use \TabletopWargaming\Euclidean\Distance\Range\Simple as SimpleRange;

class NamedSpec extends ObjectBehavior
{
    public function let($range, $start, $end)
    {
        $range->beADoubleOf('\TabletopWargaming\Euclidean\Distance\Range\Simple');
        $start->beADoubleOf('\TabletopWargaming\Euclidean\Distance\Length\Measure');
        $end->beADoubleOf('\TabletopWargaming\Euclidean\Distance\Length\Measure');
        $range->getStart()->willReturn($start);
        $range->getEnd()->willReturn($end);
        $this->beConstructedWith($range);
    }

    function it_should_implement_nameable()
    {
        $this->shouldHaveType('\TabletopWargaming\Common\Interfaces\Named');
    }

    function it_should_return_the_start_length($start)
    {
        $this->getStart()->shouldReturn($start);
    }

    function it_should_return_the_end_Length($end)
    {
        $this->getEnd()->shouldReturn($end);
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
        Measure $start,
        Measure $end,
        Measure $in
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

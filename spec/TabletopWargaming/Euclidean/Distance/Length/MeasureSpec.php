<?php

namespace spec\TabletopWargaming\Euclidean\Distance\Length;

use \PhpSpec\ObjectBehavior;
use \Prophecy\Argument;
use TabletopWargaming\Common\Interfaces\Comparable;
use TabletopWargaming\Euclidean\Distance\Length\Measure;
use \TabletopWargaming\Euclidean\System\Distance;
use \TabletopWargaming\Euclidean\System\Distance\Simple as SimpleDistance;

class MeasureSpec extends ObjectBehavior
{
    function it_returns_the_measurement_i_give_it(SimpleDistance $system)
    {
        $distance = 24;
        $this->beConstructedWith($distance, $system);
        $this->getDistance()->shouldReturn($distance);
    }

    function it_is_to_stringable()
    {
        $inches = new SimpleDistance(Distance::IMPERIAL, Distance::INCHES, Distance::INCH_MICRO, '%d"');
        $this->beConstructedWith(48, $inches);
        $this->__toString()->shouldReturn('48"');

    }

    function it_returns_a_valid_measurement_if_i_subtract_from_it()
    {
        $inches = new SimpleDistance(Distance::IMPERIAL, Distance::INCHES, Distance::INCH_MICRO, '%d"');
        $this->beConstructedWith(48, $inches);
        $metric = new SimpleDistance(Distance::METRIC, Distance::CM, Distance::CM_MICRO, '%dcm');
        $that  = new Measure(40, $metric);
        $theOther = new Measure(81.92, $metric);
        $this->subtract($that)->shouldMatchMeasure($theOther);
        $this->getDistance()->shouldReturn(48);
    }

    function it_returns_a_valid_measurement_if_i_add_to_it()
    {
        $inches = new SimpleDistance(Distance::IMPERIAL, Distance::INCHES, Distance::INCH_MICRO, '%d"');
        $this->beConstructedWith(48, $inches);
        $metric = new SimpleDistance(Distance::METRIC, Distance::CM, Distance::CM_MICRO, '%dcm');
        $that  = new Measure(40, $metric);
        $theOther = new Measure(161.92, $metric);
        $this->add($that)->shouldMatchMeasure($theOther);
        $this->getDistance()->shouldReturn(48);
    }

    function it_returns_the_system_i_give_it(SimpleDistance $system)
    {
        $distance = 24;
        $this->beConstructedWith($distance, $system);
        $this->getSystem()->shouldReturn($system);
        $this->isInfinite()->shouldReturn(false);
    }

    function it_says_whether_it_is_greater_than_another_measurement()
    {
        $inches = new SimpleDistance(Distance::IMPERIAL, Distance::INCHES, Distance::INCH_MICRO, '%d"');
        $this->beConstructedWith(48, $inches);
        $that = new Measure(47, $inches);
        $this->isGreaterThan($that)->shouldReturn(true);
        $this->isLessThan($that)->shouldReturn(false);
        $this->isEqualTo($that)->shouldReturn(false);
    }

    function it_says_whether_it_is_less_than_another_measurement()
    {
        $inches = new SimpleDistance(Distance::IMPERIAL, Distance::INCHES, Distance::INCH_MICRO, '%d"');
        $this->beConstructedWith(48, $inches);
        $that = new Measure(49, $inches);
        $this->isLessThan($that)->shouldReturn(true);
        $this->isGreaterThan($that)->shouldReturn(false);
        $this->isEqualTo($that)->shouldReturn(false);

    }

    function it_says_whether_it_is_equal_to_another_measurement()
    {
        $inches = new SimpleDistance(Distance::IMPERIAL, Distance::INCHES, Distance::INCH_MICRO, '%d"');
        $this->beConstructedWith(48, $inches);
        $that = new Measure(48, $inches);
        $this->isLessThan($that)->shouldReturn(false);
        $this->isGreaterThan($that)->shouldReturn(false);
        $this->isEqualTo($that)->shouldReturn(true);
    }


    function it_can_compare_with_another_object()
    {
        $inches = new SimpleDistance(Distance::IMPERIAL, Distance::INCHES, Distance::INCH_MICRO, '%d"');
        $this->beConstructedWith(48, $inches);
        $that = new Measure(48.1, $inches);
        $this->compare($that)->shouldReturn(Comparable::LESS_THAN);
        $that = new Measure(48, $inches);
        $this->compare($that)->shouldReturn(Comparable::EQUAL_TO);
        $that = new Measure(47.99, $inches);
        $this->compare($that)->shouldReturn(Comparable::GREATER_THAN);
    }

    function it_can_be_infinite()
    {
        $inches = new SimpleDistance(Distance::IMPERIAL, Distance::INCHES, Distance::INCH_MICRO, '%d"');
        $this->beConstructedWith(INF, $inches);
        $this->isInfinite()->shouldReturn(true);
    }

    function it_immutably_can_be_converted()
    {
        $inches = new SimpleDistance(Distance::IMPERIAL, Distance::INCHES, Distance::INCH_MICRO, '%d"');
        $metric = new SimpleDistance(Distance::METRIC, Distance::CM, Distance::CM_MICRO, '%dcm');
        $metricMeasure = new Measure(121.92, $metric);
        $this->beConstructedWith(48, $inches);
        $this->convertTo($metric)->shouldMatchMeasure($metricMeasure);
    }

    public function getMatchers()
    {
        return [
          'matchMeasure' => function($measurement1, $measurement2) {
              return bccomp($measurement1->toBase(), $measurement2->toBase());
          }
        ];
    }
}

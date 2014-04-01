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
    public function let()
    {
        $inches = new SimpleDistance(
            Distance::IMPERIAL,
            Distance::INCHES,
            Distance::INCH_MM,
            '%d"'
        );
        $this->beConstructedWith(48, $inches); // 1219.2 millimetres
    }

    function it_returns_the_measurement_i_give_it(SimpleDistance $system)
    {
        $distance = 24;
        $this->beConstructedWith($distance, $system);
        $this->getDistance()->shouldReturn($distance);
    }

    function it_is_to_stringable()
    {
        $this->__toString()->shouldReturn('48"');

    }

    function it_returns_a_valid_measurement_if_i_subtract_from_it()
    {
        $metric = new SimpleDistance(Distance::METRIC, Distance::CM, Distance::CM_MM, '%dcm');
        $that  = new Measure(40, $metric);
        $theOther = new Measure(81.92, $metric);
        $this->subtract($that)->shouldMatchMeasure($theOther);
        $this->getDistance()->shouldReturn(48);
    }

    function it_returns_a_valid_measurement_if_i_add_to_it()
    {
        $metric = new SimpleDistance(Distance::METRIC, Distance::CM, Distance::CM_MM, '%dcm');
        $that  = new Measure(40, $metric);
        $theOther = new Measure(161.9, $metric);

        $this->add($that)->shouldMatchMeasure($theOther);
        $this->getDistance()->shouldReturn(48);
    }

    function it_returns_a_valid_measure_when_i_divide_it()
    {
        $inches = new SimpleDistance(
            Distance::IMPERIAL,
            Distance::INCHES,
            Distance::INCH_MM,
            '%d"'
        );
        $quarter = new Measure(12, $inches);
        $this->divide(4)->shouldMatchMeasure($quarter);
    }

    function it_returns_a_valid_measure_when_i_multiply_it()
    {
        $inches = new SimpleDistance(
            Distance::IMPERIAL,
            Distance::INCHES,
            Distance::INCH_MM,
            '%d"'
        );
        $quarter = new Measure(144, $inches);
        $this->multiply(3)->shouldMatchMeasure($quarter);
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
        $inches = $this->getWrappedObject()->getSystem();
        $that = new Measure(47, $inches);
        $this->isGreaterThan($that)->shouldReturn(true);
        $this->isLessThan($that)->shouldReturn(false);
        $this->isEqualTo($that)->shouldReturn(false);
    }

    function it_says_whether_it_is_less_than_another_measurement()
    {
        $inches = new SimpleDistance(
            Distance::IMPERIAL,
            Distance::INCHES,
            Distance::INCH_MM,
            '%d"'
        );
        $that = new Measure(49, $inches);
        $this->isLessThan($that)->shouldReturn(true);
        $this->isGreaterThan($that)->shouldReturn(false);
        $this->isEqualTo($that)->shouldReturn(false);

    }

    function it_says_whether_it_is_equal_to_another_measurement()
    {
        $inches = new SimpleDistance(
            Distance::IMPERIAL,
            Distance::INCHES,
            Distance::INCH_MM,
            '%d"'
        );
        $that = new Measure(48, $inches);
        $this->isLessThan($that)->shouldReturn(false);
        $this->isGreaterThan($that)->shouldReturn(false);
        $this->isEqualTo($that)->shouldReturn(true);
    }


    function it_can_compare_with_another_object()
    {
        $inches = new SimpleDistance(
            Distance::IMPERIAL,
            Distance::INCHES,
            Distance::INCH_MM,
            '%d"'
        );;
        $that = new Measure(48.1, $inches);
        $this->compare($that)->shouldReturn(Comparable::LESS_THAN);
        $that = new Measure(48, $inches);
        $this->compare($that)->shouldReturn(Comparable::EQUAL_TO);
        $that = new Measure(47.99, $inches);
        $this->compare($that)->shouldReturn(Comparable::GREATER_THAN);
    }

    function it_can_be_infinite()
    {
        $inches = new SimpleDistance(
            Distance::IMPERIAL,
            Distance::INCHES,
            Distance::INCH_MM,
            '%d"'
        );
        $this->beConstructedWith(INF, $inches);
        $this->isInfinite()->shouldReturn(true);
    }

    function it_immutably_can_be_converted()
    {
        $inches = new SimpleDistance(
            Distance::IMPERIAL,
            Distance::INCHES,
            Distance::INCH_MM,
            '%d"'
        );
        $metric = new SimpleDistance(Distance::METRIC, Distance::CM, Distance::CM_MM, '%dcm');
        $metricMeasure = new Measure(121.92, $metric);
        $this->beConstructedWith(48, $inches);
        $this->convertTo($metric)->shouldMatchMeasure($metricMeasure);
    }

    public function getMatchers()
    {
        return [
          'matchMeasure' => function(Measure $measurement1, Measure $measurement2) {
              $first = $measurement1->toBase();
              $second = $measurement2->toBase();
              $match = bccomp(
                  $first,
                  $second,
                  $measurement2->getScale()
              );
              if (0 !== $match) {
                  throw new \Exception("$match ($first) ($second)");
              }
              return true;
          }
        ];
    }
}

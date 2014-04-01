<?php

namespace spec\TabletopWargaming\Euclidean\System\Distance;

use \PhpSpec\ObjectBehavior;
use \Prophecy\Argument;
use \TabletopWargaming\Euclidean\System\Distance;

class SimpleSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(
            Distance::IMPERIAL,
            Distance::INCHES,
            Distance::INCH_MM,
            '%d"'
        );
    }

    function it_gives_me_the_system_name()
    {
        $this->getName()->shouldReturn(Distance::IMPERIAL);
    }

    function it_gives_me_the_unit_name()
    {
        $this->getUnit()->shouldReturn(Distance::INCHES);
    }

    function it_gives_me_the_unit_name_when_tostringed()
    {
        $this->__toString()->shouldReturn(Distance::INCHES);
    }

    function it_gives_me_a_rendered_string()
    {
        $this->render(24)->shouldReturn('24"');
    }

    function it_gives_me_a_rendered_string_with_the_correct_suffix()
    {
        $this->beConstructedWith(
            Distance::METRIC,
            Distance::CM,
            Distance::CM_MM,
            '%dcm'
        );
        $this->render(24)->shouldReturn('24cm');
    }

    function it_gives_me_the_base_value()
    {
        $this->toBase(24)->shouldReturn(6096);
    }

    function it_gives_me_the_unit_value()
    {
        $this->toUnit(12192)->shouldReturn((double) 48);
    }
}

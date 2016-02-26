<?php

namespace spec\Sickle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SickleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sickle\Sickle');
    }
    function it_returns_hello()
    {
        $this->hello()->shouldReturn('Hello World');
    }
}

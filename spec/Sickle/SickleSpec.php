<?php

namespace spec\Sickle;

use Sickle\Sickle;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SickleSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Sickle\Sickle');
    }

    function it_can_set_og_title()
    {
        $this->setTitle('A title');
        $this->render()->shouldContain('<meta property="og:title" content="A title">');
    }

    function it_can_set_og_description(){
        $this->setTitle('A title');
        $this->setDescription('A super fine description');
        $this->render()->shouldContain('<meta property="og:title" content="A title">');
        $this->render()->shouldContain('<meta property="og:description" content="A super fine description">');
    }

    function it_should_have_og_title()
    {
        $this->shouldThrow(new \Exception('Open Graph title is required'))->duringRender();
    }

    function it_should_sanitize_content()
    {
        $description = <<<EOL
        This description    contains some
           <h1>html</h1> tags   and
               other garbage
        <p>content</p>
EOL;

        $this->setTitle('A title');
        $this->setDescription($description);
        $this->render()->shouldContain('<meta property="og:description" content="This description contains some html tags and other garbage content">');
    }
}

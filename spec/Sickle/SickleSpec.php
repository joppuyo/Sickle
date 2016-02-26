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
        $this->setUrl('http://example.com');
        $this->render()->shouldContain('<meta property="og:title" content="A title">');
    }

    function it_can_set_og_description(){
        $this->setTitle('A title');
        $this->setUrl('http://example.com');
        $this->setDescription('A super fine description');
        $this->render()->shouldContain('<meta property="og:title" content="A title">');
        $this->render()->shouldContain('<meta property="og:description" content="A super fine description">');
    }

    function it_should_have_og_title()
    {
        $this->shouldThrow(new \Exception('Open Graph title is required'))->duringRender();
    }

    function it_should_have_og_url()
    {
        $this->setTitle('A title');
        $this->shouldThrow(new \Exception('Open Graph URL is required'))->duringRender();
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
        $this->setUrl('http://example.com');
        $this->setDescription($description);
        $this->render()->shouldContain('<meta property="og:description" content="This description contains some html tags and other garbage content">');
    }

    function it_should_validate_url()
    {
        $this->setTitle('A title');
        $this->setUrl('../test.html');
        $this->shouldThrow(new \Exception('Open Graph URL is malformed. Please provide a valid absolute URL'))->duringRender();
    }
}

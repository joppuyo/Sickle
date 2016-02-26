<?php

namespace Sickle;

use PhpSpec\Exception\Exception;

class Sickle {

    public $OpenGraph;
    private $title;
    private $openGraphEnabled = true;

    public function __construct()
    {
        $this->openGraph = new OpenGraph();
    }

    public function setTitle($title){
        $this->openGraph->setTitle($title);
    }

    public function setDescription($description){
        $this->openGraph->setDescription($description);
    }

    public function render()
    {
        $output = '';
        if ($this->openGraphEnabled) {
            if (empty($this->openGraph->getTitle())) {
                throw new Exception('Open Graph title is required');
            } else {
                $output .= sprintf('<meta property="og:title" content="%s">', $this->openGraph->getTitle());
            }
            if (!empty($this->openGraph->getDescription())) {
                $output .= sprintf('<meta property="og:description" content="%s">', $this->openGraph->getDescription());
            }
        }
        return $output;
    }
}
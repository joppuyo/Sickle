<?php

namespace Sickle;

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

    public function render()
    {
        $output = '';
        if ($this->openGraphEnabled) {
            $output .= sprintf('<meta property="og:title" content="%s">', $this->openGraph->getTitle());
        }
        return $output;
    }
}
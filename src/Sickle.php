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

    private function sanitize($string){
        $string = trim(strip_tags($string));
        $string =  preg_replace("/\s+/", " ", $string);
        return $string;
    }

    private function renderTag($property, $content){
        $content = $this->sanitize($content);
        return sprintf('<meta property="%s" content="%s">', $property, $content);
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
                $output .= $this->renderTag('og:title', $this->openGraph->getTitle());
            }
            if (!empty($this->openGraph->getDescription())) {
                $output .= $this->renderTag('og:description', $this->openGraph->getDescription());
            }
        }
        return $output;
    }
}
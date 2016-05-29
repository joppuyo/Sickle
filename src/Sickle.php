<?php

namespace Sickle;

use PhpSpec\Exception\Exception;

class Sickle {

    public $OpenGraph;
    private $openGraphEnabled = true;
    private $twitterCardsEnabled = false;

    public function __construct()
    {
        $this->openGraph = new OpenGraph();
        $this->twitterCards = new TwitterCards();
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
        $this->twitterCards->setTitle($title);
    }

    public function setDescription($description){
        $this->openGraph->setDescription($description);
        $this->twitterCards->setDescription($description);
    }

    public function setUrl($url){
        $this->openGraph->setUrl($url);
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
            if (empty($this->openGraph->getUrl())) {
                throw new Exception('Open Graph URL is required');
            } else if (!filter_var($this->openGraph->getUrl(),FILTER_VALIDATE_URL)){
                throw new Exception('Open Graph URL is malformed. Please provide a valid absolute URL');
            } else {
                $output .= $this->renderTag('og:url', $this->openGraph->getUrl());
            }
        }

        // Enable Twitter Cards automatically when site is set
        if ($this->twitterCards->getSite()) {
            $this->twitterCardsEnabled = true;
        }

        if ($this->twitterCardsEnabled) {

            // Unless especially defined, ff there is no image, use "summary" which does not require image. Else, use
            // summary large image" to get parity with Open Graph
            if (!$this->twitterCards->getCardType()) {
                if (empty($this->twitterCards->getImage())) {
                    $this->twitterCards->setCardType('summary');
                } else {
                    $this->twitterCards->setCardType('summary_large_image');
                }
            }

            if (empty($this->twitterCards->getTitle())) {
                throw new \Exception('Twitter Cards title must be set');
            }

            if (empty($this->twitterCards->getDescription())) {
                throw new \Exception('Twitter Cards description must be set');
            }

            if (empty($this->twitterCards->getSite())) {
                throw new \Exception('Twitter Cards site must be set');
            }

            $output .= $this->renderTag('twitter:title', $this->twitterCards->getTitle());
            $output .= $this->renderTag('twitter:description', $this->twitterCards->getDescription());
            $output .= $this->renderTag('twitter:site', $this->twitterCards->getSite());
            $output .= $this->renderTag('twitter:card', $this->twitterCards->getCardType());

        }
        return $output;
    }
}
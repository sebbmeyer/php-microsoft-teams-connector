<?php

namespace Sebbmyr\Teams\Cards\Adaptive\Elements;

/**
 * Media element
 *
 * CURRENTLY NOT SUPPORTED BY TEAMS
 *
 * @version 1.1
 * @see https://adaptivecards.io/explorer/Media.html
 */
class Media extends BaseElement implements AdaptiveCardElement
{
    /**
     * Array of media sources to attempt to play.
     * Required: yes
     * Type: MediaSources[]
     * @version 1.1
     * @var array
     */
    private $sources;

    /**
     * URL of an image to display before playing.
     * Supports data URI in version 1.2+
     * Required: no
     * @version 1.1
     * @var string
     */
    private $poster;

    /**
     * Alternate text describing the audio or video.
     * Required: no
     * @version 1.1
     * @var string
     */
    private $altText;

    public function __construct($sources = null)
    {
        $this->setType("Media");
        $this->sources = $sources;
    }

    /**
     * Returns content of card element
     * @param  float $version
     * @return array
     */
    public function getContent($version)
    {
        // if sources is not set, throw exception
        if (!isset($this->sources)) {
            throw new \Exception("Card element sources is not set", 500);
        }
        $element = $this->getBaseContent(
            ["sources" => $this->getSourcesContent($version)],
            $version
        );

        if (isset($this->poster) && $version >= 1.1) {
            $element["poster"] = $this->poster;
        }

        if (isset($this->altText) && $version >= 1.1) {
            $element["altText"] = $this->altText;
        }

        return $element;
    }

    /**
     * Returns generated sources content
     *
     * @param  float $version
     * @return array
     */
    private function getSourcesContent($version)
    {
        $sources = [];

        foreach ($this->sources as $source) {
            if ($source instanceof MediaSource) {
                $sources[] = $source->getContent($version);
            } else {
                $sources[] = $source;
            }
        }

        return $sources;
    }

    /**
     * Sets sources
     * @param array $sources
     * @return Media
     */
    public function setSources($sources)
    {
        if (!isset($this->sources)) {
            $this->sources = [];
        }

        foreach ($sources as $source) {
            if ($source instanceof MediaSource) {
                $this->addMediaSource($source);
            } else {
                $this->sources[] = $source;
            }
        }

        return $this;
    }

    /**
     * Sets poster
     * @param string $poster
     * @return Media
     */
    public function setPoster($poster)
    {
        $this->poster = $poster;

        return $this;
    }

    /**
     * Sets alternative text
     * @param string $altText
     * @return Media
     */
    public function setAltText($altText)
    {
        $this->altText = $altText;

        return $this;
    }

    /**
     * Adds MediaSource object to sources
     * @param MediaSource $source
     * @return Media
     */
    public function addMediaSource(MediaSource $source)
    {
        if (!isset($this->sources)) {
            $this->sources = [];
        }

        $this->sources[] = $source;

        return $this;
    }
}

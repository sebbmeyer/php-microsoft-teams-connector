<?php

namespace Sebbmyr\Teams\Cards\Adaptive\Elements;

/**
 * MediaSource element
 *
 * CURRENTLY NOT SUPPORTED BY TEAMS
 *
 * @todo add mime type check
 *
 * @version 1.1
 * @see https://adaptivecards.io/explorer/MediaSource.html
 */
class MediaSource implements AdaptiveCardElement
{
    /**
     * Mime type of associated media (e.g. "video/mp4").
     * Required: yes
     * @version
     * @var string
     */
    private $mimeType;

    /**
     * URL to media. Supports data URI in version 1.2+
     * Required: yes
     * @version 1.1
     * @var string
     */
    private $url;

    
    public function __construct($mimeType = null, $url = null)
    {
        $this->mimeType = $mimeType;
        $this->url = $url;
    }

    /**
     * Returns content of card element
     * @param  float $version
     * @return array
     */
    public function getContent($version)
    {
        if (!isset($this->mimeType)) {
            throw new \Exception("Card element mime type is not set", 500);
        }
        if (!isset($this->url)) {
            throw new \Exception("Card element url is not set", 500);
        }

        return [
            "mimeType" => $this->mimeType,
            "url" => $this->url,
        ];
    }

    /**
     * Sets mime type
     * @param string $mimeType
     * @return MediaSource
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Sets url
     * @param string $url
     * @return MediaSource
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}

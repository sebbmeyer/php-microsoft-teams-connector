<?php

namespace Sebbmyr\Teams\Cards\Adaptive\Actions;

/**
 * OpenUrl action
 *
 * @see https://adaptivecards.io/explorer/Action.OpenUrl.html
 */
class OpenUrl extends BaseAction implements AdaptiveCardAction
{
    /**
     * The URL to open.
     * Type: uri
     * Required: yes
     * @version 1.0
     * @var string
     */
    private $url;
    
    public function __construct($url = null)
    {
        $this->setType("Action.OpenUrl");
        $this->url = $url;
    }

    /**
     * Returns content of card action
     * @param  float $version
     * @return array
     */
    public function getContent($version)
    {
        // if url is not set, throw exception
        if (!isset($this->url)) {
            throw new \Exception("Card action url is not set", 500);
        }
        $action = $this->getBaseContent(
            ["url" => $this->url],
            $version
        );

        return $action;
    }

    /**
     * Sets url
     * @param string $url
     * @return OpenUrl
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}

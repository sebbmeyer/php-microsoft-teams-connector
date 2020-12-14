<?php

namespace Sebbmyr\Teams\Cards\Adaptive\Elements;

use Sebbmyr\Teams\Cards\Adaptive\Actions\AdaptiveCardAction;

/**
 * AdaptiveCard to be used as inline element for Actions
 *
 * @version >= 1.0
 */
class AdaptiveCard implements AdaptiveCardElement
{
    /**
     * Type of element.
     * Required: yes
     * @version 1.0
     * @var string
     */
    private $type;

    /**
     * Body container of AdaptiveCard
     * Required: no
     * Type: AdaptiveCardElement[]
     * @version 1.0
     * @var array
     */
    private $body;

    /**
     * Actions container of AdaptiveCard
     * Required: no
     * Type: AdaptiveCardAction[]
     * @version 1.0
     * @var array
     */
    private $actions;
    
    public function __construct()
    {
        $this->setType("AdaptiveCard");
    }

    /**
     * Returns content of card element
     * @param  float $version
     * @return array
     */
    public function getContent($version)
    {
        // if type is not set, throw exception
        if (!isset($this->type)) {
            throw new \Exception("Card element type is not set", 500);
        }

        $element = [
            'type' => $this->type,
        ];

        if (isset($this->body) && $version >= 1.0) {
            $element["body"] = $this->getBodyContent($version);
        }

        if (isset($this->actions) && $version >= 1.0) {
            $element["actions"] = $this->getActionsContent($version);
        }


        return $element;
    }

    /**
     * Returns generated body content
     * @param  float $version
     * @return array
     */
    private function getBodyContent($version)
    {
        $body = [];

        foreach ($this->body as $item) {
            if ($item instanceof AdaptiveCardElement) {
                $body[] = $item->getContent($version);
            }
        }

        return $body;
    }

    /**
     * Returns generated actions content
     * @param  float $version
     * @return array
     */
    private function getActionsContent($version)
    {
        $actions = [];

        foreach ($this->actions as $item) {
            if ($item instanceof AdaptiveCardAction) {
                $actions[] = $item->getContent($version);
            }
        }

        return $actions;
    }

    /**
     * Sets type of element
     * @param string $type
     * @return AdaptiveCard
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Adds element to card body
     * @param AdaptiveCardElement $element
     * @return AdaptiveCard
     */
    public function addElement(AdaptiveCardElement $element)
    {
        if (!isset($this->body)) {
            $this->body = [];
        }

        $this->body[] = $element;

        return $this;
    }

    /**
     * Adds action to card actions
     * @param AdaptiveCardAction $action
     * @return AdaptiveCard
     */
    public function addAction(AdaptiveCardAction $action)
    {
        if (!isset($this->actions)) {
            $this->actions = [];
        }

        $this->actions[] = $action;

        return $this;
    }
}

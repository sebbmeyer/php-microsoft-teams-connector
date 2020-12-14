<?php

namespace Sebbmyr\Teams\Cards\Adaptive\Actions;

use Sebbmyr\Teams\Cards\Adaptive\AdaptiveCard;
use Sebbmyr\Teams\Cards\Adaptive\Elements\AdaptiveCardElement;

/**
 * ShowCard action
 */
class ShowCard extends BaseAction implements AdaptiveCardAction
{

    private $card;
    
    public function __construct()
    {
        $this->setType("Action.ShowCard");
        $this->card = new AdaptiveCard();
    }

    /**
     * Returns content of card action
     * @param  float $version
     * @return array
     */
    public function getContent($version)
    {
        $action = $this->getBaseContent(
            ["card" => $this->card->getContent($version)],
            $version
        );

        return $action;
    }

    /**
     * Adds element to card body
     * @param AdaptiveCardElement $element
     * @return AdaptiveCard
     */
    public function addElement(AdaptiveCardElement $element)
    {
        $this->card->addElement($element);

        return $this;
    }

    /**
     * Adds action to card actions
     * @param AdaptiveCardAction $action
     * @return AdaptiveCard
     */
    public function addAction(AdaptiveCardAction $action)
    {
        $this->card->addAction($action);

        return $this;
    }
}

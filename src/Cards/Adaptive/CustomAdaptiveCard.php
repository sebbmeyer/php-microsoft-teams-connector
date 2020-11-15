<?php

namespace Sebbmyr\Teams\Cards\Adaptive;

use Sebbmyr\Teams\AbstractCard as Card;
use Sebbmyr\Teams\Cards\Adaptive\Actions\AdaptiveCardAction;
use Sebbmyr\Teams\Cards\Adaptive\Elements\AdaptiveCardElement;

/**
 * Custom adaptive card
 *
 * "Action.Submit" is currently not supported
 *
 * @see https://docs.microsoft.com/en-us/microsoftteams/platform/webhooks-and-connectors/how-to/connectors-using#send-adaptive-cards-using-an-incoming-webhook
 *
 * @todo add "speak" property
 * @todo add "lang" property
 * @todo add "backgroundImage" property
 * @todo add "minHeight" property
 * @todo add "fallbackText" property
 * @todo add "verticalContentAlignment" property
 * @todo add "selectAction" property
 */
class CustomAdaptiveCard extends Card
{
    /**
     * Supported version of adaptive cards
     * @var float
     */
    public $version;

    /**
     * The body of the card is made up of building-blocks known as elements.
     * "Elements" can be composed in nearly infinite arrangements to create many types of cards
     * Type: Array of Elements
     * @var array
     */
    private $body;

    /**
     * Many cards have a set of actions a user may take on it.
     * This property describes those actions
     * which typically get rendered in an "action bar" at the bottom.
     * Type: Array of action objects
     * @var array
     */
    private $actions;

    private $supportedVersions = [1.0, 1.1, 1.2];

    public function __construct($version = 1.2)
    {
        if (in_array($version, $this->supportedVersions)) {
            $this->version = $version;
        } else {
            $this->version = 1.2;
        }
    }

    /**
     * Formats data for API call
     */
    public function getMessage()
    {
        $card = [
            "contentType" => "application/vnd.microsoft.card.adaptive",
            "contentUrl" => null,
            "content" => [
                "\$schema" => "http://adaptivecards.io/schemas/adaptive-card.json",
                "type" => "AdaptiveCard",
                "version" => $this->version,
            ],
        ];

        if (isset($this->body)) {
            $card["content"]["body"] = $this->body;
        }

        if (isset($this->actions)) {
            $card["content"]["actions"] = $this->actions;
        }

        $message = [
            "type" => "message",
            "attachments" => [$card],
        ];

        return $message;
    }

    /**
     * Adds single element to card body
     *
     * @param AdaptiveCardElement $element
     * @return CustomAdaptiveCard
     */
    public function addElement(AdaptiveCardElement $element)
    {
        if (!isset($this->body)) {
            $this->body = [];
        }

        $this->body[] = $element->getContent($this->version);

        return $this;
    }

    /**
     * Adds single action to card actions
     *
     * @param AdaptiveCardAction $value
     * @return CustomAdaptiveCard
     */
    public function addAction(AdaptiveCardAction $action)
    {
        if (!isset($this->actions)) {
            $this->actions = [];
        }

        $this->actions[] = $action->getContent($this->version);

        return $this;
    }
}

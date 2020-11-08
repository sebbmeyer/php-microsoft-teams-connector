<?php

namespace Sebbmyr\Teams\AdaptiveCards;

use Sebbmyr\Teams\AbstractCard as Card;

/**
 * Hero card for microsoft teams
 *
 * "tap" property is currently not supported
 *
 * @see https://docs.microsoft.com/en-us/microsoftteams/platform/task-modules-and-cards/cards/cards-reference#hero-card
 */
class HeroCard extends Card
{

    /**
     * Title of the card. Maximum 2 lines.
     * Type: Rich text
     * @var string
     */
    private $title;

    /**
     * Subtitle of the card. Maximum 2 lines.
     * Type: Rich text
     * @var string
     */
    private $subtitle;

    /**
     * Text appears just below the subtitle.
     * Type: Rich text
     * @var string
     */
    private $text;

    /**
     * Image displayed at top of card. Aspect ratio 16:9.
     * Currently only the first image of the array will be shown in teams
     * Type: Array of images
     * @var array
     */
    private $images;

    /**
     * Set of actions applicable to the current card. Maximum 6
     * Type: Array of action objects
     * @var array
     */
    private $buttons;
    
    public function getMessage()
    {
        $card = [
            "contentType" => "application/vnd.microsoft.card.hero",
            "content" => [],
        ];

        if (isset($this->title)) {
            $card["content"]["title"] = $this->title;
        }

        if (isset($this->subtitle)) {
            $card["content"]["subtitle"] = $this->subtitle;
        }

        if (isset($this->text)) {
            $card["content"]["text"] = $this->text;
        }

        if (isset($this->images)) {
            $card["content"]["images"] = $this->images;
        }

        if (isset($this->buttons)) {
            $card["content"]["buttons"] = $this->buttons;
        }

        $message = [
            "type" => "message",
            "attachments" => [$card],
        ];

        return $message;
    }

    /**
     * Sets card title
     *
     * @param string $title
     * @return HeroCard
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Sets card text
     *
     * @param string $text
     * @return HeroCard
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Sets card subtitle
     *
     * @param string $subtitle
     * @return HeroCard
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;

        return $this;
    }


    /**
     * Adds single image to card
     *
     * @param string $url
     * @return HeroCard
     */
    public function addImage($url)
    {
        if (!isset($this->images)) {
            $this->images = [];
        }
        $this->images[] = [
            "url" => $url,
        ];

        return $this;
    }

    /**
     * Adds single button to card
     *
     * @param string $type
     * @param string $title
     * @param string $value
     */
    public function addButton($type, $title, $value)
    {
        if (!isset($this->buttons)) {
            $this->buttons = [];
        }
        
        $this->buttons[] = [
            "type" => $type,
            "title" => $title,
            "value" => $value,
        ];

        return $this;
    }
}

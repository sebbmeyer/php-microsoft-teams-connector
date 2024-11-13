<?php

namespace Sebbmyr\Teams\Cards\Adaptive\Elements;

/**
 * RichTextBlock element
 *
 * @version >= 1.2
 * @see https://adaptivecards.io/explorer/RichTextBlock.html
 */
class RichTextBlock extends BaseElement implements AdaptiveCardElement
{
    /**
     * The array of inlines.
     * Required: yes
     * Type: Inline[]
     * @version 1.2
     * @var array
     */
    private $inlines;

    /**
     * Controls the horizontal text alignment.
     * Type: HorizontalAligment
     * Required: no
     * @version 1.2
     * @var string
     */
    private $horizontalAlignment;
    
    public function __construct($inlines = null)
    {
        $this->setType("RichTextBlock");
        $this->inlines = $inlines;
    }

    /**
     * Returns content of card element
     * @param  float $version
     * @return array
     */
    public function getContent($version)
    {
        // if inlines is not set, throw exception
        if (!isset($this->inlines)) {
            throw new \Exception("Card element inlines is not set", 500);
        }

        $element = $this->getBaseContent(
            ["inlines" => $this->getInlinesContent($version)],
            $version
        );

        if (isset($this->horizontalAlignment) && $version >= 1.2) {
            $element["horizontalAlignment"] = $this->horizontalAlignment;
        }

        return $element;
    }

    /**
     * Returns generated inlines content
     *
     * @param  float $version
     * @return array
     */
    private function getInlinesContent($version)
    {
        $inlines = [];

        foreach ($this->inlines as $item) {
            if ($item instanceof TextRun) {
                $inlines[] = $item->getContent($version);
            } else {
                $inlines[] = $item;
            }
        }

        return $inlines;
    }

    /**
     * Sets inlines
     * @param array $inlines
     * @return RichTextBlock
     */
    public function setInlines($inlines)
    {
        if (!isset($this->inlines)) {
            $this->inlines = [];
        }

        foreach ($inlines as $inline) {
            if ($inline instanceof TextRun || is_string($inline)) {
                $this->inlines[] = $inline;
            }
        }

        return $this;
    }

    /**
     * Sets horizontal alignment. Available options can be found in Styles.php
     * @param string $alignment
     * @return RichTextBlock
     */
    public function setHorizontalAlignment($alignment)
    {
        $this->horizontalAlignment = $alignment;

        return $this;
    }

    /**
     * Adds text to inlines
     * @param string $text
     * @return RichTextBlock
     */
    public function addText($text)
    {
        if (!isset($this->inlines)) {
            $this->inlines = [];
        }

        if (!is_string($text)) {
            return $this;
        }

        $this->inlines[] = $text;

        return $this;
    }

    /**
     * Adds TextRun object to inlines
     * @param TextRun $text
     * @return RichTextBlock
     */
    public function addTextRun(TextRun $text)
    {
        if (!isset($this->inlines)) {
            $this->inlines = [];
        }

        $this->inlines[] = $text;

        return $this;
    }
}

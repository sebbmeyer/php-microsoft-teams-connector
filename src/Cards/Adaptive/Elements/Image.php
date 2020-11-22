<?php

namespace Sebbmyr\Teams\Cards\Adaptive\Elements;

/**
 * Image element
 *
 * "selectAction" property is currently not support
 *
 * @todo add checks to predefined styles, e.g. BlockElementHeight "auto" and "stretch"
 * @todo add "selectAction" property support
 *
 * @see https://adaptivecards.io/explorer/Image.html
 */
class Image extends BaseElement implements AdaptiveCardElement
{
    /**
     * The URL to the image. Supports data URI in version 1.2+
     * Required: yes
     * @version 1.0
     * @var string
     */
    private $url;

    /**
     * Alternate text describing the image.
     * Required: no
     * @version 1.0
     * @var string
     */
    private $altText;

    /**
     * Applies a background to a transparent image. This property will respect the image style.
     * Required: no
     * @version 1.1
     * @var string
     */
    private $backgroundColor;

    /**
     * The desired height of the image. If specified as a pixel value,
     * ending in ‘px’, E.g., 50px, the image will distort to fit
     * that exact height. This overrides the size property.
     * Type: string, BlockElementHeight
     * Default: "auto"
     * Required: no
     * @version 1.1
     * @var string
     */
    private $height;

    /**
     * Controls the horizontal text alignment.
     * Type: HorizontalAligment
     * Required: no
     * @version 1.0
     * @var string
     */
    private $horizontalAlignment;

    /**
     * An Action that will be invoked when the "Image" is tapped or selected.
     * "Action.ShowCard" is not supported.
     * Type: ISelectAction
     * Required: no
     * @version 1.1
     * @var string
     */
    private $selectAction;

    /**
     * Controls the approximate size of the image. The physical dimensions will vary per host.
     * Type: ImageSize
     * Required: no
     * @version 1.0
     * @var string
     */
    private $size;

    /**
     * Controls how this "Image" is displayed.
     * Type: ImageStyle
     * Required: no
     * @version 1.0
     * @var string
     */
    private $style;

    /**
     * The desired on-screen width of the image, ending in ‘px’. E.g., 50px.
     * This overrides the size property.
     * Required: no
     * @version 1.1
     * @var string
     */
    private $width;

    public function __construct($url = null)
    {
        $this->setType("Image");
        $this->url = $url;
    }

    /**
     * Returns content of card element
     * @param  float $version
     * @return array
     */
    public function getContent($version)
    {
        // if url is not set, throw exception
        if (!isset($this->url)) {
            throw new \Exception("Card element url is not set", 500);
        }
        $element = $this->getBaseContent(
            ["url" => $this->url],
            $version
        );

        if (isset($this->altText) && $version >= 1.0) {
            $element["altText"] = $this->altText;
        }

        if (isset($this->backgroundColor) && $version >= 1.1) {
            $element["backgroundColor"] = $this->backgroundColor;
        }

        if (isset($this->height) && $version >= 1.1) {
            $element["height"] = $this->height;
        }

        if (isset($this->horizontalAlignment) && $version >= 1.0) {
            $element["horizontalAlignment"] = $this->horizontalAlignment;
        }

        if (isset($this->selectAction) && $version >= 1.1) {
            $element["selectAction"] = $this->selectAction;
        }

        if (isset($this->size) && $version >= 1.0) {
            $element["size"] = $this->size;
        }

        if (isset($this->style) && $version >= 1.0) {
            $element["style"] = $this->style;
        }

        if (isset($this->width) && $version >= 1.1) {
            $element["width"] = $this->width;
        }

        return $element;
    }

    /**
     * Sets text
     * @param string $url
     * @return Image
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Sets alternative text
     * @param string $altText
     * @return Image
     */
    public function setAltText($altText)
    {
        $this->altText = $altText;

        return $this;
    }

    /**
     * Sets background color
     * @param string $backgroundColor
     * @return Image
     */
    public function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    /**
     * Sets height. Available options can be found in Styles.php
     * @param string $height [description]
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Sets horizontal aligment. Available options can be found in Styles.php
     * @param string $alignment
     * @return Image
     */
    public function setHorizontalAlignment($alignment)
    {
        $this->horizontalAlignment = $alignment;

        return $this;
    }

    /**
     * Sets image size. Available options can be found in Styles.php
     * @param string $size
     * @return Image
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Sets image style. Available options can be found in Styles.php
     * @param string $style
     * @return Image
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }

    /**
     * Sets width
     * @param string $width [description]
     * @return Image
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }
}

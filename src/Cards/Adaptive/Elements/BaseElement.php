<?php

namespace Sebbmyr\Teams\Cards\Adaptive\Elements;

/**
 * Base element
 *
 * "fallback" and "requires" properties are currently not supported
 */
class BaseElement
{
    /**
     * Type of element.
     * Required: yes
     * @version 1.0
     * @var string
     */
    private $type;

    /**
     * Describes what to do when an unknown element is encountered or
     * the requires of this or any children can’t be met.
     * Type: Element, FallbackOption
     * Required: no
     * @version 1.1
     * @var [type]
     */
    private $fallback;

    /**
     * Specifies the height of the element.
     * Type: BlockElementHeight
     * Required: no
     * @version 1.1
     * @var string
     */
    private $height;

    /**
     * When true, draw a separating line at the top of the element.
     * Default: false
     * Required: no
     * @version 1.0
     * @var boolean
     */
    private $separator;

    /**
     * Controls the amount of spacing between this element and the preceding element.
     * Type: Spacing
     * Required: no
     * @version 1.0
     * @var string
     */
    private $spacing;

    /**
     * A unique identifier associated with the item.
     * Required: no
     * @version 1.0
     * @var string
     */
    private $id;

    /**
     * If false, this item will be removed from the visual tree.
     * Default: true
     * Required: no
     * @version 1.2
     * @var boolean
     */
    private $isVisible;

    /**
     * A series of key/value pairs indicating features that the item requires
     * with corresponding minimum version. When a feature is missing or
     * of insufficient version, fallback is triggered.
     * Type: Dictionary<string>
     * Required: no
     * @version 1.2
     * @var array
     */
    private $requires;

    /**
     * Adds base properties to given element and returns it
     * @param  array  $element
     * @param  float  $version
     * @return array
     */
    public function getBaseContent(array $element, $version)
    {
        // if type is not set, throw exception
        if (!isset($this->type)) {
            throw new \Exception("Card element type is not set", 500);
        }
        $element["type"] = $this->type;

        if (isset($this->fallback) && $version >= 1.1) {
            $element["fallback"] = $this->fallback;
        }

        if (isset($this->height) && $version >= 1.1) {
            $element["height"] = $this->height;
        }

        if (isset($this->separator) && $version >= 1.0) {
            $element["separator"] = $this->separator;
        }

        if (isset($this->spacing) && $version >= 1.0) {
            $element["spacing"] = $this->spacing;
        }

        if (isset($this->id) && $version >= 1.0) {
            $element["id"] = $this->id;
        }

        if (isset($this->isVisible) && $version >= 1.2) {
            $element["isVisible"] = $this->isVisible;
        }

        if (isset($this->requires) && $version >= 1.2) {
            $element["requires"] = $this->requires;
        }

        return $element;
    }

    /**
     * Sets type of element
     * @param string $type
     * @return BaseElement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Sets height. Available options can be found in Styles.php
     * @param string $height
     * @return BaseElement
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Sets separator flag
     * @param bool $separator
     * @return BaseElement
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;

        return $this;
    }

    /**
     * Sets spacing. Available options can be found in Styles.php
     * @param string $spacing
     * @return BaseElement
     */
    public function setSpacing($spacing)
    {
        $this->spacing = $spacing;

        return $this;
    }

    /**
     * Sets id
     * @param string $id
     * @return BaseElement
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Sets isVisible flag
     * @param bool $isVisible
     * @return BaseElement
     */
    public function setIsVisible($isVisible)
    {
        $this->isVisible = $isVisible;

        return $this;
    }
}

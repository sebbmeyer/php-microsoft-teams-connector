<?php

namespace Sebbmyr\Teams\Cards\Adaptive\Actions;

/**
 * Base action
 *
 * @todo add "fallback" property support
 * @todo add "requires" property support
 */
class BaseAction
{
    /**
     * Type of element.
     * Required: yes
     * @version 1.0
     * @var string
     */
    private $type;

    /**
     * Label for button or link that represents this action.
     * Required: no
     * @version 1.0
     * @var string
     */
    private $title;

    /**
     * Optional icon to be shown on the action in conjunction with the title.
     * Supports data URI in version 1.2+
     * Type: uri
     * Required: no
     * @version 1.1
     * @var string
     */
    private $iconUrl;

    /**
     * Controls the style of an Action, which influences how the action is displayed,
     * spoken, etc.
     * Type: ActionStyle
     * Required: no
     * @version 1.2
     * @var string
     */
    private $style;

    /**
     * Describes what to do when an unknown element is encountered or
     * the requires of this or any children can’t be met.
     * Type: Action, FallbackOption
     * Required: no
     * @version 1.2
     * @var [type]
     */
    private $fallback;

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
     * Adds base properties to given action and returns it
     * @param  array  $action
     * @param  float  $version
     * @return array
     */
    public function getBaseContent(array $action, $version)
    {
        // if type is not set, throw exception
        if (!isset($this->type)) {
            throw new \Exception("Card action type is not set", 500);
        }
        $action["type"] = $this->type;

        if (isset($this->title) && $version >= 1.0) {
            $action["title"] = $this->title;
        }

        if (isset($this->iconUrl) && $version >= 1.1) {
            $action["iconUrl"] = $this->iconUrl;
        }

        if (isset($this->style) && $version >= 1.2) {
            $action["style"] = $this->style;
        }

        if (isset($this->fallback) && $version >= 1.2) {
            $action["fallback"] = $this->fallback;
        }

        if (isset($this->requires) && $version >= 1.2) {
            $action["requires"] = $this->requires;
        }

        return $action;
    }

    /**
     * Sets type of action
     * @param string $type
     * @return BaseAction
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Sets title
     * @param string $title
     * @return BaseAction
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Sets icon url
     * @param string $iconUrl
     * @return BaseAction
     */
    public function setIconUrl($iconUrl)
    {
        $this->iconUrl = $iconUrl;

        return $this;
    }

    /**
     * Sets action style. Available options can be found in Styles.php
     * @param string $style
     * @return BaseAction
     */
    public function setStyle($style)
    {
        $this->style = $style;

        return $this;
    }
}

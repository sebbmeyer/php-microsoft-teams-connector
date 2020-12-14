<?php

namespace Sebbmyr\Teams\Cards\Adaptive\Elements;

/**
 * Fact
 *
 * @version >= 1.0
 * @see https://adaptivecards.io/explorer/Fact.html
 */
class Fact
{

    /**
     * The title of the fact.
     * Required: yes
     * @version 1.0
     * @var string
     */
    private $title;

    /**
     * The value of the fact.
     * Required: yes
     * @version 1.0
     * @var string
     */
    private $value;
    
    public function __construct($title, $value)
    {
        $this->title = $title;
        $this->value = $value;
    }

    /**
     * Return fact content
     * @return array
     */
    public function getContent()
    {
        return [
            'title' => $this->title,
            'value' => $this->value,
        ];
    }
}

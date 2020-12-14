<?php

namespace Sebbmyr\Teams\Cards\Adaptive\Elements;

/**
 * FactSet card element
 */
class FactSet extends BaseElement implements AdaptiveCardElement
{

    /**
     * The array of Fact's.
     * Required: yes
     * Type: Fact[]
     * @version 1.0
     * @var array
     */
    private $facts;
    
    public function __construct($facts = null)
    {
        $this->setType("FactSet");
        $this->facts = $facts;
    }

    /**
     * Returns content of card element
     * @param  float $version
     * @return array
     */
    public function getContent($version)
    {
        // if facts is not set, throw exception
        if (!isset($this->facts)) {
            throw new \Exception("Card element facts is not set", 500);
        }

        $element = $this->getBaseContent(
            ["facts" => $this->getFactsContent()],
            $version
        );

        return $element;
    }

    /**
     * Returns generated facts content
     * @return array
     */
    private function getFactsContent()
    {
        $facts = [];

        foreach ($this->facts as $fact) {
            if ($fact instanceof Fact) {
                $facts[] = $fact->getContent();
            }
        }

        return $facts;
    }

    /**
     * Adds fact to element
     * @param Fact $fact
     * @return FactSet
     */
    public function addFact(Fact $fact)
    {
        if (!isset($this->facts)) {
            $this->facts = [];
        }

        $this->facts[] = $fact;

        return $this;
    }
}

<?php

namespace Sebbmyr\Teams;

/**
 * Abstract card
 */
abstract class AbstractCard implements CardInterface
{
    /**
     * @var array
     */
    public $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Returns message card array
     *
     * @return array
     */
    abstract public function getMessage();
}

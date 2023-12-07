<?php

namespace Sebbmyr\Teams\Cards\Adaptive\Contracts;

/**
 * Contract for displaying adaptive card in full width
 */
trait FullWidth
{
    /**
     * Flag to display cards full width in channel
     *
     * @var bool
     */
    protected $fullWidth = false;

    /**
     * Sets fullWidth flag
     *
     * @param bool $fullWidth
     * @return mixed
     */
    public function setFullWidth($fullWidth)
    {
        $this->fullWidth = $fullWidth;

        return $this;
    }
}

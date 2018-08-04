<?php

namespace Sebbmyr\Teams;

interface TeamsConnectorInterface
{

    /**
     * Returns message card array
     *
     * @return array
     */
    public function getMessage();
}

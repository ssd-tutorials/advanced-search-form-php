<?php

use App\Model\Location;

class LocationTest extends LookupModelCase
{
    /**
     * Get instance of a given model.
     *
     * @return \App\Model\Model
     */
    protected function modelInstance()
    {
        return new Location;
    }
}
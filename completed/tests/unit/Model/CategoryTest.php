<?php

use App\Model\Category;

class CategoryTest extends LookupModelCase
{
    /**
     * Get instance of a given model.
     *
     * @return \App\Model\Model
     */
    protected function modelInstance()
    {
        return new Category;
    }
}
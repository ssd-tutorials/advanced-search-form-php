<?php

use App\Model\Language;

class LanguageTest extends LookupModelCase
{
    /**
     * Get instance of a given model.
     *
     * @return \App\Model\Model
     */
    protected function modelInstance()
    {
        return new Language;
    }
}
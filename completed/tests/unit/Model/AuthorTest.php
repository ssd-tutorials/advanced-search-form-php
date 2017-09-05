<?php

use App\Model\Author;

class AuthorTest extends LookupModelCase
{
    /**
     * Get instance of a given model.
     *
     * @return \App\Model\Model
     */
    protected function modelInstance()
    {
        return new Author;
    }
}
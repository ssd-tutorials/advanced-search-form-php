<?php

use App\Search\Filter\Book\Year;
use App\Search\Filter\Book\Cover;
use App\Search\Filter\Book\Author;
use App\Search\Filter\Book\Keyword;
use App\Search\Filter\Book\Category;
use App\Search\Filter\Book\Language;
use App\Search\Filter\Book\Location;
use App\Search\Filter\FilterManager;

trait SearchFilterManager
{
    /**
     * Get filter manager.
     *
     * @return FilterManager
     */
    protected function filter()
    {
        return  FilterManager::make()
                ->add('keyword', Keyword::filter())
                ->add('category', Category::filter())
                ->add('author', Author::filter())
                ->add('year', Year::filter())
                ->add('language', Language::filter())
                ->add('cover', Cover::filter())
                ->add('location', Location::filter());
    }
}
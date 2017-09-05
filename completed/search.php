<?php

use App\Container;

use App\Model\Book;

use App\Search\Filter\Book\Year;
use App\Search\Filter\Book\Cover;
use App\Search\Filter\Book\Author;
use App\Search\Filter\Book\Keyword;
use App\Search\Filter\Book\Category;
use App\Search\Filter\Book\Language;
use App\Search\Filter\Book\Location;
use App\Search\Filter\FilterManager;

use App\Search\Search;
use App\Search\Sticky;

$filter = FilterManager::make()
        ->add('keyword', Keyword::filter())
        ->add('category', Category::filter())
        ->add('author', Author::filter())
        ->add('year', Year::filter())
        ->add('language', Language::filter())
        ->add('cover', Cover::filter())
        ->add('location', Location::filter());

$search = new Search(
    Container::get('request'),
    $filter->keys()
);

$sticky = new Sticky($search);

$books = (new Book)->search($search, $filter)->orderBy('title')->paginate(2);
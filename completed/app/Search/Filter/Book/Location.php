<?php

namespace App\Search\Filter\Book;

use App\Search\Filter\FilterContract;

use App\Database\Filter;
use App\Database\Concat\ConcatAnd;
use App\Database\Statement\Query\Exists;
use App\Database\Statement\SubQuery\Pivot\Exists\PivotExistsIn;

class Location implements FilterContract
{
    /**
     * Get filter.
     *
     * @return Filter
     */
    public static function filter()
    {
        return new Filter(
            [
                new Exists(
                    'books.id',
                    new PivotExistsIn(
                        'book_location',
                        'book_id',
                        'location_id',
                        'books.id'
                    ),
                    true
                )
            ],
            new ConcatAnd
        );
    }
}
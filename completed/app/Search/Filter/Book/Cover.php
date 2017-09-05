<?php

namespace App\Search\Filter\Book;

use App\Search\Filter\FilterContract;

use App\Database\Filter;
use App\Database\Concat\ConcatAnd;
use App\Database\Statement\Query\Exists;
use App\Database\Statement\SubQuery\Pivot\Exists\PivotExistsEquals;

class Cover implements FilterContract
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
                    new PivotExistsEquals(
                        'book_cover',
                        'book_id',
                        'cover_id',
                        'books.id'
                    )
                )
            ],
            new ConcatAnd
        );
    }
}
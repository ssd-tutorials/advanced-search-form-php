<?php

namespace App\Search\Filter\Book;

use App\Search\Filter\FilterContract;

use App\Database\Filter;
use App\Database\Concat\ConcatAnd;
use App\Database\Statement\Query\Exists;
use App\Database\Statement\SubQuery\Pivot\Exists\PivotExistsEquals;

class Author implements FilterContract
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
                        'author_book',
                        'book_id',
                        'author_id',
                        'books.id'
                    )
                )
            ],
            new ConcatAnd
        );
    }
}
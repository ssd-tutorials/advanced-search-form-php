<?php

namespace App\Search\Filter\Book;

use App\Search\Filter\FilterContract;

use App\Database\Filter;
use App\Database\Concat\ConcatAnd;
use App\Database\Statement\Query\Exists;
use App\Database\Statement\SubQuery\Pivot\Exists\PivotExistsEquals;

class Language implements FilterContract
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
                        'book_language',
                        'book_id',
                        'language_id',
                        'books.id'
                    )
                )
            ],
            new ConcatAnd
        );
    }
}
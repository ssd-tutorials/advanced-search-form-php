<?php

namespace App\Search\Filter\Book;

use App\Search\Filter\FilterContract;

use App\Database\Filter;
use App\Database\Concat\ConcatOr;
use App\Database\Concat\ConcatAndWrap;
use App\Database\Statement\Query\LikePercentBoth;

class Keyword implements FilterContract
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
                new LikePercentBoth('books.title'),
                new LikePercentBoth('books.description')
            ],
            new ConcatAndWrap,
            new ConcatOr
        );
    }
}
<?php

namespace App\Search\Filter;

use App\Database\Filter;

interface FilterContract
{
    /**
     * Get filter.
     *
     * @return Filter
     */
    public static function filter();
}
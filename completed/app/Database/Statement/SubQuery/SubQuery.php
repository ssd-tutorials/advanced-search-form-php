<?php

namespace App\Database\Statement\SubQuery;

interface SubQuery
{
    /**
     * Get query string for a pivot table.
     *
     * @return string
     */
    public function query();
}
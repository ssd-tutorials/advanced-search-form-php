<?php

namespace App\Database\Statement\Query;

class Exists extends Query
{
    /**
     * @var string
     */
    protected $operand = 'EXISTS';

    /**
     * Get sub-query sql statement.
     *
     * @param mixed $value
     * @return string
     */
    protected function subQueryStatement($value)
    {
        return "{$this->operand} ({$this->subQuery($value)})";
    }
}
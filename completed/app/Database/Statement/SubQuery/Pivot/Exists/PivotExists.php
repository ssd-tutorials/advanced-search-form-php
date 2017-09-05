<?php

namespace App\Database\Statement\SubQuery\Pivot\Exists;

use App\Database\Statement\Field;
use App\Database\Statement\SubQuery\Pivot\Pivot;

abstract class PivotExists extends Pivot
{
    /**
     * @var string
     */
    protected $outer_field;

    /**
     * PivotExists constructor.
     *
     * @param string $table
     * @param string $select_field
     * @param string $where_field
     * @param string $outer_field
     */
    public function __construct(
        $table,
        $select_field,
        $where_field,
        $outer_field
    )
    {
        parent::__construct($table, $select_field, $where_field);

        $this->outer_field = Field::fieldName($outer_field);
    }

    /**
     * Get query string for a pivot table.
     *
     * @return string
     */
    public function query()
    {
        return $this->statement() . " AND {$this->select_field} = {$this->outer_field}";
    }

}
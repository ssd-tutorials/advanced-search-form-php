<?php

namespace App\Database\Statement\SubQuery\Pivot;

use App\Database\Statement\Field;
use App\Database\Statement\SubQuery\SubQuery;

abstract class Pivot implements SubQuery
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $select_field;

    /**
     * @var string
     */
    protected $where_field;

    /**
     * @var string
     */
    protected $operand = '=';

    /**
     * Pivot constructor.
     *
     * @param string $table
     * @param string $select_field
     * @param string $where_field
     */
    public function __construct($table, $select_field, $where_field)
    {
        $this->table = $table;
        $this->select_field = Field::fieldName($select_field);
        $this->where_field = Field::fieldName($where_field);
    }

    /**
     * Common sql statement.
     *
     * @return string
     */
    protected function statement()
    {
        return "SELECT {$this->select_field}
                FROM `{$this->table}`
                WHERE {$this->where_field} {$this->operand} ?";
    }

    /**
     * Get query string for a pivot table.
     *
     * @return string
     */
    public function query()
    {
        return $this->statement();
    }
}
<?php

namespace App\Database\Statement\Query;

use App\Database\Statement\Field;
use App\Database\Statement\SubQuery\SubQuery;

abstract class Query
{
    /**
     * @var string
     */
    protected $field;

    /**
     * @var string
     */
    protected $operand = '=';

    /**
     * @var string
     */
    protected $binder = '$';

    /**
     * @var null|SubQuery
     */
    protected $sub_query = null;

    /**
     * @var bool
     */
    protected $replace_sub_query;

    /**
     * Query constructor.
     *
     * @param string $field
     * @param SubQuery $sub_query
     * @param bool $replace_sub_query
     */
    public function __construct(
        $field,
        SubQuery $sub_query = null,
        $replace_sub_query = false
    )
    {
        $this->field = Field::fieldName($field);
        $this->sub_query = $sub_query;
        $this->replace_sub_query = $replace_sub_query;
    }

    /**
     * Get sql statement.
     *
     * @param mixed $value
     * @return string
     */
    public function statement($value)
    {
        if ($this->hasSubQuery()) {
            return $this->subQueryStatement($value);
        }

        return "{$this->field} {$this->operand} ?";
    }

    /**
     * Check if there is a sub-query.
     *
     * @return bool
     */
    public function hasSubQuery()
    {
        return (
            $this->sub_query instanceof SubQuery
        );
    }

    /**
     * Get sub-query sql statement.
     *
     * @param mixed $value
     * @return string
     */
    protected function subQueryStatement($value)
    {
        return "{$this->field} {$this->operand} ({$this->subQuery($value)})";
    }

    /**
     * Replace placeholder with value
     * directly within the sub-query.
     *
     * @param mixed $value
     * @return null|string
     */
    protected function subQuery($value)
    {
        if ( ! $this->replaceSubQuery() || ! is_array($value)) {
            return $this->sub_query->query();
        }

        return str_replace("?", $this->value($value), $this->sub_query->query());
    }

    /**
     * Check if value should be placed
     * directly in the sub-query.
     *
     * @return bool
     */
    public function replaceSubQuery()
    {
        return $this->replace_sub_query;
    }

    /**
     * Get value based on the binder expression.
     *
     * @param mixed $value
     * @return mixed
     */
    public function value($value)
    {
        return str_replace('$', $this->sanitiseValue($value), $this->binder);
    }

    /**
     * Sanitise value.
     *
     * @param mixed $value
     * @return mixed
     */
    private function sanitiseValue($value)
    {
        if ( ! is_array($value)) {
            return $value;
        }

        $value = array_map('intval', $value);
        return '(' . implode(', ', $value) . ')';
    }
}
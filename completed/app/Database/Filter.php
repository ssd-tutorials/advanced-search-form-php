<?php

namespace App\Database;

use App\Database\Concat\ConcatAnd;
use App\Database\Concat\ConcatContract;
use App\Database\Statement\Query\Query;

class Filter
{
    /**
     * @var array
     */
    private $queries = [];

    /**
     * @var ConcatContract
     */
    private $outer_concat;

    /**
     * @var ConcatContract
     */
    private $inner_concat;

    /**
     * @var array
     */
    private $statements = [];

    /**
     * @var array
     */
    private $values = [];

    /**
     * Filter constructor.
     *
     * @param array $queries
     * @param ConcatContract|null $outer_concat
     * @param ConcatContract|null $inner_concat
     */
    public function __construct(
        array $queries,
        ConcatContract $outer_concat = null,
        ConcatContract $inner_concat = null
    )
    {
        $this->queries = $queries;
        $this->setOuterConcat($outer_concat);
        $this->setInnerConcat($inner_concat);
    }

    /**
     * Set outer concatenator.
     *
     * @param ConcatContract|null $concat
     */
    private function setOuterConcat(ConcatContract $concat = null)
    {
        $this->outer_concat = $concat ?: new ConcatAnd;
    }

    /**
     * Set inner concatenator.
     *
     * @param ConcatContract|null $concat
     */
    private function setInnerConcat(ConcatContract $concat = null)
    {
        $this->inner_concat = $concat ?: new ConcatAnd;
    }

    /**
     * Process queries.
     *
     * @param mixed $value
     * @return $this
     */
    public function filter($value)
    {
        $this->clear();

        foreach($this->queries as $query) {
            $this->addStatement($query, $value);
            $this->addValue($query, $value);
        }

        return $this;
    }

    /**
     * Clear statements and values.
     *
     * @return void
     */
    private function clear()
    {
        $this->statements = [];
        $this->values = [];
    }

    /**
     * Add statement to the statements collection.
     *
     * @param Query $query
     * @param $value
     * @return void
     */
    private function addStatement(Query $query, $value)
    {
        if (empty($this->statements)) {
            $this->statements[] = $query->statement($value);
            return;
        }

        $this->statements[] = $this->inner_concat->concat($query->statement($value));
    }

    /**
     * Add value to the values collection.
     *
     * @param Query $query
     * @param $value
     * @return void
     */
    private function addValue(Query $query, $value)
    {
        if ($query->replaceSubQuery()) {
            return;
        }

        $this->values[] = $query->value($value);
    }

    /**
     * Get concatenated statement.
     *
     * @param bool $first
     * @return string
     */
    public function statement($first = false)
    {
        $statement = implode(" ", $this->statements);

        if ($first) {
            return $this->outer_concat->concatFirst($statement);
        }

        return $this->outer_concat->concat($statement);
    }

    /**
     * Get values.
     *
     * @return array
     */
    public function values()
    {
        return $this->values;
    }
}
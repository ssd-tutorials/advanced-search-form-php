<?php

namespace App\Model;

use App\Database\Filter;
use App\Pagination\Pagination;
use App\Pagination\Paginator;
use App\Pagination\SelectPaginationView;
use App\Search\Filter\FilterManager;
use App\Search\Search;
use Exception;
use App\Container;

abstract class Model
{
    /**
     * @var string
     */
    protected $table;

    /**
     * Partials of a single sql statement.
     *
     * @var array
     */
    private $statements = [];

    /**
     * Values for the sql statement.
     *
     * @var array
     */
    private $statement_values = [];

    /**
     * Sql select statement.
     *
     * @return string
     */
    public function sql()
    {
        return "SELECT *
                FROM `{$this->table}`";
    }

    /**
     * Get table name.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->table;
    }

    /**
     * Create new record.
     *
     * @param array $values
     * @return mixed
     * @throws Exception
     */
    public function insert(array $values)
    {
        return Container::get('db')->insert($this->table, $values);
    }

    /**
     * Create new record and return model instance.
     *
     * @param array $values
     * @return mixed
     * @throws Exception
     */
    public function create(array $values)
    {
        if ( ! $this->insert($values)) {
            throw new Exception("Record could not be added");
        }

        return $this->find(Container::get('db')->lastInsertId());
    }

    /**
     * Get class instance.
     *
     * @param $id
     * @param string $field
     * @return mixed
     * @throws Exception
     */
    public function find($id, $field = 'id')
    {
        return Container::get('db')->fetchObject(
            $this->sql() . " WHERE `{$this->table}`.`{$field}` = ?",
            $id,
            static::class
        );
    }

    /**
     * Update record.
     *
     * @param array $values
     * @param $id
     * @param string $field
     * @return Model
     * @throws Exception
     */
    public function update(array $values, $id, $field = 'id')
    {
        if ( ! Container::get('db')->update($this->table, $values, $id, $field)) {
            throw new Exception("Record could not be updated");
        }

        return $this->find($id, $field);
    }

    /**
     * Remove record.
     *
     * @param $id
     * @param string $field
     * @return mixed
     * @throws Exception
     */
    public function delete($id, $field = 'id')
    {
        return Container::get('db')->delete($this->table, $id, $field);
    }

    /**
     * Get all records.
     *
     * @return mixed
     * @throws Exception
     */
    public function all()
    {
        return Container::get('db')->fetchObjects(
            $this->fullStatement(),
            $this->statement_values,
            static::class
        );
    }

    /**
     * Get full sql statement.
     *
     * @param null $append
     * @return string
     */
    public function fullStatement($append = null)
    {
        return $this->sql() . $this->statement($append);
    }

    /**
     * Get combined sql statement.
     *
     * @param null $append
     * @return string
     */
    private function statement($append = null)
    {
        return implode(" ", $this->statements) . $append;
    }

    /**
     * Order by statement.
     *
     * @param null|string $order_by
     * @param string $direction
     * @return $this
     */
    public function orderBy($order_by = null, $direction = 'ASC')
    {
        if (is_null($order_by)) {
            $this->orderByClause("`{$this->table}`.`id`", $direction);
            return $this;
        }

        $order_by = explode('.', $order_by);

        if (count($order_by) === 1) {
            $this->orderByClause("`{$this->table}`.`{$order_by[0]}`", $direction);
            return $this;
        }

        $this->orderByClause("`{$order_by[0]}`.`{$order_by[1]}`", $direction);

        return $this;
    }

    /**
     * Add order by statement
     * to a collection of statements.
     *
     * @param string $field
     * @param string $direction
     * @return void
     */
    private function orderByClause($field, $direction)
    {
        $this->statements[] = " ORDER BY {$field} {$direction}";
    }

    /**
     * Limit statement.
     *
     * @param int $limit
     * @param int $offset
     * @return string
     */
    public function limit($limit, $offset = 0)
    {
        return " LIMIT {$limit} OFFSET {$offset}";
    }

    /**
     * Get filtered list of records.
     *
     * @param Search $search
     * @param FilterManager $filter
     * @return $this
     */
    public function search(Search $search, FilterManager $filter)
    {
        if ($search->isCollectionEmpty()) {
            return $this;
        }

        foreach($search->collection as $key => $value) {
            $this->addFilter($filter->get($key), $value);
        }

        return $this;
    }

    /**
     * Add where filter.
     *
     * @param Filter $filter
     * @param $value
     * @return void
     */
    private function addFilter(Filter $filter, $value)
    {
        $filter->filter($value);

        $this->addStatementValues($filter->values());

        if (empty($this->statements)) {
            $this->addFirstStatement($filter);
            return;
        }

        $this->statements[] = $filter->statement();
    }

    /**
     * Add values for the statement.
     *
     * @param array $values
     * @return void
     */
    private function addStatementValues(array $values)
    {
        $this->statement_values = array_merge($this->statement_values, $values);
    }

    /**
     * Add first where statement.
     *
     * @param Filter $filter
     * @return void
     */
    private function addFirstStatement(Filter $filter)
    {
        $this->statements[] = " WHERE ";
        $this->statements[] = $filter->statement(true);
    }

    /**
     * Get a Paginator instance.
     *
     * @param int $limit
     * @param string $key
     * @return Paginator
     */
    public function paginate($limit = 10, $key = 'page')
    {
        $count = Container::get('db')->count(
            $this->table,
            $this->statement(),
            $this->statement_values
        );

        $pagination = new SelectPaginationView(
            new Pagination(
                Container::get('request'),
                $count,
                $limit,
                $key
            )
        );

        $records = Container::get('db')->fetchObjects(
            $this->fullStatement(
                $this->limit(
                    $pagination->limit(),
                    $pagination->offset()
                )
            ),
            $this->statement_values,
            static::class
        );

        return new Paginator($records, $pagination);
    }
}
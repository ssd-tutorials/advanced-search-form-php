<?php

namespace App\Database;

use PDO;
use PDOException;
use PDOStatement;

abstract class Database
{
    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * @var array
     */
    protected $default_options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    /**
     * @var null|int
     */
    protected $last_insert_id = null;

    /**
     * @var array
     */
    protected $fetch_mode = [];

    /**
     * Merges constructor options.
     *
     * @param array $options
     * @return array
     */
    protected function constructOptions(array $options = [])
    {
        if (empty($options)) {
            return $this->default_options;
        }

        $new_options = $this->default_options;

        foreach($options as $key => $option) {
            $new_options[$key] = $option;
        }

        return $new_options;
    }

    /**
     * Delegates method call to underlying
     * PDO object instance method.
     *
     * @param $attribute
     * @param $value
     */
    public function setAttribute($attribute, $value)
    {
        $this->pdo->setAttribute($attribute, $value);
    }

    /**
     * Execute sql statement.
     *
     * @param $sql
     * @param array $parameters
     * @param array $driver_options
     * @param bool $return
     * @return bool|PDOStatement
     */
    public function execute(
        $sql,
        array $parameters = [],
        array $driver_options = [],
        $return = true
    )
    {
        $statement = $this->statement($sql, $driver_options);

        $result = $statement->execute($parameters);

        if ($return) {
            return $result;
        }

        return $statement;
    }

    /**
     * Prepare sql statement.
     *
     * @param $sql
     * @param array $driver_options
     * @return PDOStatement
     */
    private function statement($sql, array $driver_options = [])
    {
        $statement = $this->pdo->prepare($sql, $driver_options);

        if ( ! $statement) {
            throw new PDOException("Query statement failed");
        }

        return $statement;
    }

    /**
     * Add new record to the database.
     *
     * @param $table
     * @param array $data
     * @return bool
     */
    public function insert($table, array $data)
    {
        $sql  = "INSERT INTO `{$table}` (`";
        $sql .= implode("`, `", array_keys($data));
        $sql .= "`) VALUES (";
        $sql .= implode(", ", array_fill(0, count($data), "?"));
        $sql .= ")";

        if ( ! $this->execute($sql, array_values($data))) {
            return false;
        }

        $this->last_insert_id = $this->pdo->lastInsertId();

        return true;
    }

    /**
     * Get last insert id.
     *
     * @return int|null
     */
    public function lastInsertId()
    {
        return $this->last_insert_id;
    }

    /**
     * Update record.
     *
     * @param $table
     * @param array $data
     * @param $id
     * @param string $field
     * @return bool|PDOStatement
     */
    public function update($table, array $data, $id, $field = 'id')
    {
        $values = [];

        $sql = "UPDATE `{$table}` SET ";

        foreach($data as $key => $value) {

            $sql .= "`{$key}` = ?";
            $values[] = $value;

        }

        $sql .= " WHERE `{$field}` = ?";
        $values[] = $id;

        return $this->execute($sql, $values);
    }

    /**
     * Fetch object.
     *
     * @param $sql
     * @param null $parameters
     * @param null $className
     * @param array $constructorArguments
     * @return mixed
     */
    public function fetchObject(
        $sql,
        $parameters = null,
        $className = null,
        array $constructorArguments = []
    )
    {
        $className = $className ?: 'stdClass';

        $statement = $this->query($sql, (array) $parameters);

        $this->statementFetchMode(
            $statement,
            [
                PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,
                $className,
                $constructorArguments
            ]
        );

        return $statement->fetch();
    }

    /**
     * Set statement fetch mode.
     *
     * @param $statement
     * @param array $fetchMode
     * @return mixed
     */
    private function statementFetchMode(
        &$statement,
        array $fetchMode = []
    )
    {
        if ( ! empty($this->fetch_mode)) {
            $fetchMode = $this->fetch_mode;
        }

        return call_user_func_array([$statement, 'setFetchMode'], $fetchMode);
    }

    /**
     * Execute query.
     *
     * @param $sql
     * @param array $parameters
     * @param array $driver_options
     * @return PDOStatement
     */
    public function query(
        $sql,
        array $parameters = [],
        array $driver_options = []
    )
    {
        return $this->execute(
            $sql,
            $parameters,
            $driver_options,
            false
        );
    }

    /**
     * Remove record(s).
     *
     * @param $table
     * @param $id
     * @param string $field
     * @return bool|PDOStatement
     */
    public function delete($table, $id, $field = 'id')
    {
        $sql = "DELETE FROM `{$table}`
                WHERE `{$field}` = ?";

        return $this->execute($sql, [$id]);
    }

    /**
     * Count records.
     *
     * @param $table
     * @param null $where
     * @param null $parameters
     * @return mixed
     */
    public function count($table, $where = null, $parameters = null)
    {
        $sql = "SELECT COUNT(*) AS `number`
                FROM `{$table}`";

        if ( ! is_null($where)) {
            $sql .= " {$where}";
        }

        return $this->query($sql, (array) $parameters)->fetch()['number'];
    }

    /**
     * Fetch objects.
     *
     * @param string $sql
     * @param null|mixed $parameters
     * @param string $className
     * @param array $constructorArguments
     * @return array
     */
    public function fetchObjects(
        $sql,
        $parameters = null,
        $className = 'stdClass',
        array $constructorArguments = []
    )
    {
        $className = $className ?: 'stdClass';

        $statement = $this->query($sql, (array) $parameters);

        $this->statementFetchMode(
            $statement,
            [
                PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE,
                $className,
                $constructorArguments
            ]
        );

        return $statement->fetchAll();
    }
}











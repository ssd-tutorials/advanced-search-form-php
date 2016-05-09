<?php namespace App\Migration\Model;

use App\Database\Database;

class Migration
{
    /**
     * @var Database
     */
    protected $database;

    /**
     * Migration constructor.
     * @param Database $database
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * Get instance of the database.
     *
     * @return Database
     */
    public function db()
    {
        return $this->database;
    }

    /**
     * Get database type / extension.
     *
     * @return mixed
     */
    protected function type()
    {
        $class = strtolower(get_class($this->database));

        return substr($class, strripos($class, '\\') + 1);
    }

    /**
     * Get path to the query file.
     *
     * @param $fileName
     * @return string
     */
    protected function queryPath($fileName)
    {
        $type = $this->type();

        return "queries/{$type}/{$fileName}";
    }

    /**
     * Create table.
     *
     * @param $table
     * @return bool
     */
    public function create($table)
    {
        $sql = require $this->queryPath("{$table}.php");

        return $this->database->execute($sql);
    }

    /**
     * Destroy table.
     *
     * @param $table
     * @return bool
     */
    public function destroy($table)
    {
        return $this->database->execute("DROP TABLE IF EXISTS `{$table}`");
    }
}
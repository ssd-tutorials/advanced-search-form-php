<?php

namespace App\Database\Driver;

use PDO;
use App\Database\Database;

class SQLite extends Database
{
    /**
     * SQLite constructor.
     * @param $database
     * @param array $options
     */
    public function __construct($database, array $options = [])
    {
        $this->pdo = new PDO(
            'sqlite:' . $database,
            null,
            null,
            $this->constructOptions($options)
        );
    }
}
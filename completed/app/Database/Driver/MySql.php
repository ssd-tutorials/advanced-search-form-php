<?php

namespace App\Database\Driver;

use PDO;
use App\Database\Database;

class MySql extends Database
{
    /**
     * MySql constructor.
     *
     * @param string $database
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     * @param array $options
     */
    public function __construct(
        $database,
        $host = '127.0.0.1',
        $port = 3306,
        $username,
        $password,
        array $options = []
    )
    {
        $this->pdo = new PDO(
            "mysql:dbname={$database};host={$host};port={$port}",
            $username,
            $password,
            $this->constructOptions($this->parseOptions($options))
        );
    }

    /**
     * Add options to PDO constructor.
     *
     * @param array $options
     * @return array
     */
    private function parseOptions(array $options = [])
    {
        if ( ! array_key_exists(PDO::MYSQL_ATTR_INIT_COMMAND, $options)) {
            $options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8';
        }

        return $options;
    }
}
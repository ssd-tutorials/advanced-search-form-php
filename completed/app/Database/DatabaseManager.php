<?php

namespace App\Database;

use App\Database\Driver\MySql;
use App\Database\Driver\SQLite;
use SSD\DotEnv\DotEnv;

class DatabaseManager
{
    /**
     * Get Database instance.
     *
     * @param null $driver
     * @param array $options
     * @return mixed
     */
    public static function make($driver = null, array $options = [])
    {
        if (is_null($driver)) {
            $driver = DotEnv::get('DB_CONNECTION');
        }

        return call_user_func([new static, $driver], $options);
    }

    /**
     * Get SQLite instance.
     *
     * @param array $options
     * @return SQLite
     */
    protected static function sqlite(array $options = [])
    {
        return new SQLite(
            DotEnv::get('DB_DATABASE'),
            $options
        );
    }

    /**
     * Get MySql instance.
     *
     * @param array $options
     * @return MySql
     */
    protected static function mysql(array $options = [])
    {
        return new MySql(
            DotEnv::get('DB_DATABASE'),
            DotEnv::get('DB_HOST'),
            DotEnv::get('DB_PORT'),
            DotEnv::get('DB_USERNAME'),
            DotEnv::get('DB_PASSWORD'),
            $options
        );
    }
}
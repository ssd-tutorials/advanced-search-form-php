<?php

namespace App\Database\Concat;

interface ConcatContract
{
    /**
     * Concat statement.
     *
     * @param string $statement
     * @return string
     */
    public static function concat($statement);

    /**
     * Concat first statement.
     *
     * @param string $statement
     * @return string
     */
    public static function concatFirst($statement);
}
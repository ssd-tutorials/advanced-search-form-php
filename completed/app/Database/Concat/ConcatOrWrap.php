<?php

namespace App\Database\Concat;

class ConcatOrWrap implements ConcatContract
{
    /**
     * Concat statement.
     *
     * @param string $statement
     * @return string
     */
    public static function concat($statement)
    {
        return "OR ({$statement})";
    }

    /**
     * Concat first statement.
     *
     * @param string $statement
     * @return string
     */
    public static function concatFirst($statement)
    {
        return "({$statement})";
    }
}
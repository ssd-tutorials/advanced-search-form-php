<?php

namespace App\Database\Concat;

class ConcatAndWrap implements ConcatContract
{
    /**
     * Concat statement.
     *
     * @param string $statement
     * @return string
     */
    public static function concat($statement)
    {
        return "AND ({$statement})";
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
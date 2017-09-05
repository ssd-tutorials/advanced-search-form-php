<?php

namespace App\Database\Statement;

class Field
{
    /**
     * Get correct field name including table name.
     *
     * @param string $field
     * @return string
     */
    public static function fieldName($field)
    {
        $table_field = explode('.', $field, 2);

        if (count($table_field) === 1) {
            return "`{$field}`";
        }

        return "`{$table_field[0]}`.`{$table_field[1]}`";
    }
}
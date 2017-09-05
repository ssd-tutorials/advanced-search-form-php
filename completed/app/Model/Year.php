<?php

namespace App\Model;

class Year extends Model
{
    /**
     * @var string
     */
    protected $table = 'books';

    /**
     * @var int
     */
    public $year;

    /**
     * Sql statement.
     *
     * @return string
     */
    public function sql()
    {
        return "SELECT DISTINCT(`{$this->table}`.`year`) AS `year`
                FROM `{$this->table}`";
    }

    /**
     * Get all years.
     *
     * @return array
     */
    public function years()
    {
        return $this->orderBy('year')->all();
    }
}
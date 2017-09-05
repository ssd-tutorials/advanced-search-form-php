<?php

namespace App\Search\Filter;

use App\Database\Filter;

class FilterManager
{
    /**
     * @var array
     */
    private $filters = [];

    /**
     * Get new instance of itself.
     *
     * @return static
     */
    public static function make()
    {
        return new static;
    }

    /**
     * Add filter.
     *
     * @param string $name
     * @param Filter $filter
     * @return $this
     */
    public function add($name, Filter $filter)
    {
        $this->filters[$name] = $filter;

        return $this;
    }

    /**
     * Get filter by index.
     *
     * @param string $name
     * @return Filter
     */
    public function get($name)
    {
        return $this->filters[$name];
    }

    /**
     * Get all filters.
     *
     * @return array
     */
    public function all()
    {
        return $this->filters;
    }

    /**
     * Get keys.
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->filters);
    }
}
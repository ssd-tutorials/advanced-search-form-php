<?php

namespace App\Pagination;

use Exception;

abstract class PaginationView
{
    /**
     * @var Pagination
     */
    protected $pagination;

    /**
     * PaginationView constructor.
     *
     * @param Pagination $pagination
     */
    public function __construct(Pagination $pagination)
    {
        $this->pagination = $pagination;
    }

    /**
     * Get pagination html.
     *
     * @return string
     */
    public function get()
    {
        if ($this->pagination->hasOnlyOnePage()) {
            return '';
        }

        return $this->html();
    }

    /**
     * Get pagination html.
     *
     * @return string
     */
    abstract public function html();

    /**
     * Delegate calls to selected methods,
     * not declared within the view
     * to the Pagination class instance.
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     * @throws Exception
     */
    public function __call($name, array $arguments)
    {
        if ( ! in_array($name, ['limit', 'offset', 'numberOfRecords'])) {
            throw new Exception("Method {$name} was not found");
        }

        return call_user_func_array([$this->pagination, $name], $arguments);
    }

}
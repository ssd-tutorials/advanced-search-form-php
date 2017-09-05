<?php

namespace App\Pagination;

class Paginator
{
    /**
     * @var array
     */
    private $records;

    /**
     * @var PaginationView
     */
    private $pagination;

    /**
     * Paginator constructor.
     *
     * @param array $records
     * @param PaginationView $pagination
     */
    public function __construct(array $records = [], PaginationView $pagination)
    {
        $this->records = $records;
        $this->pagination = $pagination;
    }

    /**
     * Get records.
     *
     * @return array
     */
    public function records()
    {
        return $this->records;
    }

    /**
     * Get pagination html.
     *
     * @return string
     */
    public function pagination()
    {
        return $this->pagination->get();
    }

    /**
     * Check if there are any records.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->records);
    }

    /**
     * Get total number of records.
     *
     * @return int
     */
    public function count()
    {
        return $this->pagination->numberOfRecords();
    }
}
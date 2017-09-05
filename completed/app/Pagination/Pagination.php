<?php

namespace App\Pagination;

use Illuminate\Http\Request;

class Pagination
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var int
     */
    private $records_count;

    /**
     * @var int
     */
    private $per_page;

    /**
     * @var string
     */
    private $key;

    /**
     * @var int
     */
    private $pages_count = 1;

    /**
     * @var int
     */
    private $current = 1;

    /**
     * @var int
     */
    private $previous = 1;

    /**
     * @var int
     */
    private $next = 1;

    /**
     * Pagination constructor.
     *
     * @param Request $request
     * @param $records_count
     * @param int $per_page
     * @param string $key
     */
    public function __construct(
        Request $request,
        $records_count,
        $per_page = 10,
        $key = 'page'
    )
    {
        $this->request = $request;
        $this->records_count = $records_count;
        $this->per_page = $per_page;
        $this->key = $key;

        $this->setUp();
    }

    /**
     * Set all properties.
     *
     * @return void
     */
    private function setUp()
    {
        $this->setPages();
        $this->setCurrentPage();
        $this->setPreviousPage();
        $this->setNextPage();
    }

    /**
     * Set number of pages.
     *
     * @return void
     */
    private function setPages()
    {
        $this->pages_count = (int) ceil( $this->records_count / $this->per_page );
    }

    /**
     * Set current page.
     *
     * @return void
     */
    private function setCurrentPage()
    {
        $this->current = $this->getCurrentPage(
            $this->request->get($this->key)
        );
    }

    /**
     * Get current page.
     *
     * @param mixed|null $current_page
     * @return int
     */
    private function getCurrentPage($current_page = null)
    {
        if (is_null($current_page)) {
            return 1;
        }

        return (int) $current_page;
    }

    /**
     * Set previous page.
     *
     * @return void
     */
    private function setPreviousPage()
    {
        $this->previous = $this->getPreviousPage();
    }

    /**
     * Get previous page.
     *
     * @return int
     */
    private function getPreviousPage()
    {
        if ($this->hasOnlyOnePage() || $this->isFirstPage()) {
            return $this->current;
        }

        return $this->current - 1;
    }

    /**
     * Check if there's only one page.
     *
     * @return bool
     */
    public function hasOnlyOnePage()
    {
        return $this->records_count <= $this->per_page;
    }

    /**
     * Check if current page is the first one.
     *
     * @return bool
     */
    public function isFirstPage()
    {
        return $this->current === 1;
    }

    /**
     * Check if current page is the last one.
     *
     * @return bool
     */
    public function isLastPage()
    {
        return $this->current === $this->pages_count;
    }

    /**
     * Check if argument matches current page.
     *
     * @param mixed $value
     * @return bool
     */
    public function isCurrentPage($value)
    {
        return $this->current === (int) $value;
    }

    /**
     * Set next page.
     *
     * @return void
     */
    private function setNextPage()
    {
        $this->next = $this->getNextPage();
    }

    /**
     * Get next page.
     *
     * @return int
     */
    private function getNextPage()
    {
        if ($this->hasOnlyOnePage() || $this->isLastPage()) {
            return $this->current;
        }

        return $this->current + 1;
    }

    /**
     * Get offset.
     *
     * @return int
     */
    public function offset()
    {
        if ($this->isFirstPage()) {
            return 0;
        }

        return ($this->current - 1) * $this->per_page;
    }

    /**
     * Get number of records per page.
     *
     * @return int
     */
    public function limit()
    {
        return $this->per_page;
    }

    /**
     * Get total number of records.
     *
     * @return int
     */
    public function numberOfRecords()
    {
        return $this->records_count;
    }

    /**
     * Get number of pages.
     *
     * @return int
     */
    public function numberOfPages()
    {
        return $this->pages_count;
    }

    /**
     * Get instance of the Request object.
     *
     * @return Request
     */
    public function request()
    {
        return $this->request;
    }

    /**
     * Get pagination key.
     *
     * @return string
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * Get url.
     *
     * @param int $page_number
     * @return string
     */
    public function url($page_number)
    {
        return $this->request->fullUrlWithQuery([
            $this->key => (int) $page_number
        ]);
    }

    /**
     * Get previous url.
     *
     * @return string
     */
    public function previousUrl()
    {
        return $this->url($this->previous);
    }

    /**
     * Get current url.
     *
     * @return string
     */
    public function currentUrl()
    {
        return $this->url($this->current);
    }

    /**
     * Get next url.
     *
     * @return string
     */
    public function nextUrl()
    {
        return $this->url($this->next);
    }
}
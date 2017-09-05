<?php

use App\Pagination\Pagination;
use App\Pagination\SelectPaginationView;

use Illuminate\Http\Request;

abstract class PaginationCase extends TestCase
{
    /**
     * Set up.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $_GET = [];
    }

    /**
     * Get instance of Pagination.
     *
     * @param int $records_count
     * @param int $per_page
     * @param string $key
     * @return Pagination
     */
    public function pagination(
        $records_count,
        $per_page = 10,
        $key = 'page'
    )
    {
        return new Pagination(
            Request::capture(),
            $records_count,
            $per_page,
            $key
        );
    }

    /**
     * Get instance of pagination view.
     *
     * @param int $records_count
     * @param int $per_page
     * @param string $key
     * @return SelectPaginationView
     */
    public function selectPaginationView(
        $records_count,
        $per_page = 10,
        $key = 'page'
    )
    {
        return new SelectPaginationView(
            $this->pagination(
                $records_count,
                $per_page,
                $key
            )
        );
    }

    /**
     * Get anchor tag with button class.
     *
     * @param array $query
     * @param bool $slash
     * @return string
     */
    public function button(array $query, $slash = false)
    {
        return '<a href="' . $this->urlWithQuery($query, $slash) . '" class="button">';
    }

    /**
     * Get option tag.
     *
     * @param array $query
     * @param bool $slash
     * @param bool $selected
     * @return string
     */
    public function option(array $query, $slash = false, $selected = false)
    {
        $option  = '<option value="' . $this->urlWithQuery($query, $slash) . '"';
        $option .= $selected ? ' selected="selected"' : null;
        $option .= '>';

        return $option;
    }
}
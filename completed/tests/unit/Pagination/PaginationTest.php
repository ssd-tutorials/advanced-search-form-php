<?php


use Illuminate\Http\Request;

class PaginationTest extends PaginationCase
{
    /**
     * @test
     */
    public function returns_correct_offset()
    {
        $_GET['page'] = 3;

        $pagination = $this->pagination(200, 10);

        $this->assertEquals(
            20,
            $pagination->offset()
        );
    }

    /**
     * @test
     */
    public function returns_correct_limit()
    {
        $pagination = $this->pagination(200, 99);

        $this->assertEquals(
            99,
            $pagination->limit()
        );
    }

    /**
     * @test
     */
    public function sets_pagination_key()
    {
        $_GET['pg'] = 3;

        $pagination = $this->pagination(200, 10, 'pg');

        $this->assertEquals(
            20,
            $pagination->offset()
        );

        $this->assertEquals(
            'pg',
            $pagination->key()
        );
    }

    /**
     * @test
     */
    public function gets_total_number_of_records()
    {
        $pagination = $this->pagination(100, 10);

        $this->assertEquals(
            100,
            $pagination->numberOfRecords()
        );
    }

    /**
     * @test
     */
    public function gets_number_of_pages()
    {
        $pagination = $this->pagination(100, 10);

        $this->assertEquals(
            10,
            $pagination->numberOfPages()
        );
    }

    /**
     * @test
     */
    public function checks_if_has_only_one_page()
    {
        $pagination = $this->pagination(10, 10);

        $this->assertTrue(
            $pagination->hasOnlyOnePage()
        );
    }

    /**
     * @test
     */
    public function identifies_non_first_page()
    {
        $_GET['page'] = 3;

        $pagination = $this->pagination(200, 10);

        $this->assertFalse(
            $pagination->isFirstPage()
        );
    }

    /**
     * @test
     */
    public function identifies_first_page()
    {
        $pagination = $this->pagination(200, 10);

        $this->assertTrue(
            $pagination->isFirstPage()
        );
    }

    /**
     * @test
     */
    public function identifies_non_last_page()
    {
        $_GET['page'] = 3;

        $pagination = $this->pagination(200, 10);

        $this->assertFalse(
            $pagination->isLastPage()
        );
    }

    /**
     * @test
     */
    public function identifies_last_page()
    {
        $_GET['page'] = 10;

        $pagination = $this->pagination(100, 10);

        $this->assertTrue(
            $pagination->isLastPage()
        );
    }

    /**
     * @test
     */
    public function identifies_current_page()
    {
        $_GET['page'] = 10;

        $pagination = $this->pagination(100, 10);

        $this->assertTrue(
            $pagination->isCurrentPage(10)
        );

        $this->assertFalse(
            $pagination->isCurrentPage(12)
        );
    }

    /**
     * @test
     */
    public function returns_instance_of_request()
    {
        $pagination = $this->pagination(100);

        $this->assertInstanceOf(
            Request::class,
            $pagination->request()
        );
    }

    /**
     * @test
     */
    public function returns_page_url()
    {
        $pagination = $this->pagination(100);

        $this->assertEquals(
            $this->urlWithQuery(['page' => 9]),
            $pagination->url(9)
        );
    }

    /**
     * @test
     */
    public function returns_previous_page_url()
    {
        $_GET['page'] = 3;

        $pagination = $this->pagination(100);

        $this->assertEquals(
            $this->urlWithQuery(['page' => 2], true),
            $pagination->previousUrl()
        );
    }

    /**
     * @test
     */
    public function returns_current_page_url()
    {
        $_GET['page'] = 3;

        $pagination = $this->pagination(100);

        $this->assertEquals(
            $this->urlWithQuery(['page' => 3], true),
            $pagination->currentUrl()
        );
    }

    /**
     * @test
     */
    public function returns_next_page_url()
    {
        $_GET['page'] = 3;

        $pagination = $this->pagination(100);

        $this->assertEquals(
            $this->urlWithQuery(['page' => 4], true),
            $pagination->nextUrl()
        );
    }
}
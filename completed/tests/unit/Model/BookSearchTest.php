<?php

use App\Model\Book;
use App\Model\Location;
use App\Model\BookLocation;

use App\Search\Search;

use Illuminate\Http\Request;

class BookSearchTest extends ModelCase
{
    use ModelData, SearchFilterManager;

    /**
     * @var Book
     */
    private $book;

    /**
     * Set up before each test.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $_GET = [];

        $this->book = new Book;
    }

    /**
     * @test
     */
    public function returns_correct_number_of_records()
    {
        $_GET['location'][] = 1;
        $_GET['location'][] = 2;

        $location = new Location;
        $bookLocation = new BookLocation;

        $location1 = $location->create(['id' => 1, 'name' => 'London']);
        $location2 = $location->create(['id' => 2, 'name' => 'Brighton']);

        $book1 = $this->book->create($this->bookData(['title' => 'My Monster']));
        $book2 = $this->book->create($this->bookData(['title' => 'Forest Gump']));

        $bookLocation->insert(['book_id' => $book1->id, 'location_id' => $location1->id]);
        $bookLocation->insert(['book_id' => $book2->id, 'location_id' => $location2->id]);

        $filter = $this->filter();

        $search = new Search(
            Request::capture(),
            $filter->keys()
        );

        $books = $this->book->search($search, $filter)->books();

        $this->assertCount(
            2,
            $books,
            "Did not return 2 records"
        );
    }

    /**
     * @test
     */
    public function does_not_return_records()
    {
        $_GET['location'][] = 1;
        $_GET['location'][] = 2;

        $location = new Location;

        $location->create(['id' => 1, 'name' => 'London']);
        $location->create(['id' => 2, 'name' => 'Brighton']);
        $location3 = $location->create(['id' => 3, 'name' => 'Bristol']);

        $book = $this->book->create($this->bookData(['title' => 'My Monster']));

        (new BookLocation)->insert(['book_id' => $book->id, 'location_id' => $location3->id]);

        $filter = $this->filter();

        $search = new Search(
            Request::capture(),
            $filter->keys()
        );

        $books = $this->book->search($search, $filter)->books();

        $this->assertCount(
            0,
            $books,
            "Did not return 0 records"
        );
    }
}
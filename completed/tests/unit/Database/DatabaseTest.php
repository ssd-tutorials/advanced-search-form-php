<?php

use App\Database\Database;
use App\Database\DatabaseManager;
use App\Migration\MigrationManager;
use App\Migration\Model\Migration;

use App\Model\Book;

class DatabaseTest extends TestCase
{
    use BookStore;

    /**
     * @var Database
     */
    private $db;

    protected function setUp()
    {
        parent::setUp();

        $this->db = DatabaseManager::make();

        (new MigrationManager(new Migration($this->db)))->up();
    }

    protected function tearDown()
    {
        parent::tearDown();

        (new MigrationManager(new Migration($this->db)))->down();
    }

    /**
     * @test
     */
    public function executes_simple_query()
    {
        $result = $this->db->execute("SELECT MAX(1, 10)");

        $this->assertEquals(
            10,
            $result,
            "Query returned incorrect max value"
        );
    }

    /**
     * @test
     */
    public function inserts_new_record()
    {
        $result = $this->addBook();

        $this->assertTrue(
            $result,
            "The insert statement failed"
        );
    }

    /**
     * @test
     */
    public function updates_record()
    {
        $this->addBook(['isbn' => 123]);

        $update = $this->db->update(
            'books',
            [
                'isbn' => 456
            ],
            $this->lastInsertId
        );

        $this->assertTrue(
            $update,
            'The update statement failed'
        );

        $book = $this->db->fetchObject(
            "SELECT * FROM `books` WHERE `id` = ?",
            $this->lastInsertId
        );

        $this->assertEquals(
            456,
            $book->isbn,
            'ISBN was not updated'
        );
    }

    /**
     * @test
     */
    public function fetch_object_returns_std_class_instance()
    {
        $this->addBook(['title' => 'Book of Jungle']);

        $book = $this->db->fetchObject(
            "SELECT * FROM `books` WHERE `id` = ?",
            $this->lastInsertId
        );

        $this->assertInstanceOf(
            stdClass::class,
            $book,
            "Call to fetchObject did not return stdClass instance"
        );

        $this->assertEquals(
            'Book of Jungle',
            $book->title,
            "stdClass instance does not return correct title"
        );
    }

    /**
     * @test
     */
    public function fetch_object_returns_book_instance()
    {
        $this->addBook(['title' => 'Book of Jungle']);

        $book = $this->db->fetchObject(
            "SELECT * FROM `books` WHERE `id` = ?",
            $this->lastInsertId,
            Book::class
        );

        $this->assertInstanceOf(
            Book::class,
            $book,
            "Call to fetchObject did not return Book instance"
        );

        $this->assertEquals(
            'Book of Jungle',
            $book->title,
            "Book instance does not return correct title"
        );
    }

    /**
     * @test
     */
    public function removes_record()
    {
        $this->addBook(['title' => 'Book of Jungle']);

        $book = $this->db->fetchObject(
            "SELECT * FROM `books` WHERE `id` = ?",
            $this->lastInsertId
        );

        $this->assertNotEmpty(
            $book,
            'Book record not found'
        );

        $this->assertEquals(
            'Book of Jungle',
            $book->title,
            'Book record title does not match'
        );

        $this->db->delete('books', $book->id);

        $book = $this->db->fetchObject(
            "SELECT * FROM `books` WHERE `id` = ?",
            $this->lastInsertId
        );

        $this->assertFalse(
            $book,
            'Book record was found'
        );
    }

    /**
     * @test
     */
    public function count_returns_correct_number_of_records()
    {
        $this->addBook();
        $this->addBook();
        $this->addBook();

        $this->assertEquals(
            3,
            $this->db->count('books'),
            'Books table did not return 3 records'
        );

        $this->assertEquals(
            2,
            $this->db->count('books', ' WHERE `id` < 3'),
            'Books table did not return 2 records with id less than 3'
        );
    }

    /**
     * @test
     */
    public function fetch_objects_returns_the_correct_number_of_records()
    {
        $this->addBook(['title' => 'Book of Jungle']);
        $this->addBook(['title' => 'Game of Thrones']);

        $books = $this->db->fetchObjects("SELECT * FROM `books`");

        $this->assertCount(
            2,
            $books,
            "Fetch objects count did not return 2 records"
        );
    }

    /**
     * @test
     */
    public function fetch_objects_returns_array_of_std_class_objects()
    {
        $this->addBook(['title' => 'Book of Jungle']);
        $this->addBook(['title' => 'Game of Thrones']);

        $books = $this->db->fetchObjects("SELECT * FROM `books`");

        $this->assertInstanceOf(
            stdClass::class,
            $books[0],
            "First item does not appear to be a stdClass instance"
        );

        $this->assertInstanceOf(
            stdClass::class,
            $books[1],
            "Second item does not appear to be a stdClass instance"
        );
    }

    /**
     * @test
     */
    public function fetch_objects_returns_array_of_book_objects()
    {
        $this->addBook(['title' => 'Book of Jungle']);
        $this->addBook(['title' => 'Game of Thrones']);

        $books = $this->db->fetchObjects(
            "SELECT * FROM `books`",
            null,
            Book::class
        );

        $this->assertInstanceOf(
            Book::class,
            $books[0],
            "First item does not appear to be a Book instance"
        );

        $this->assertInstanceOf(
            Book::class,
            $books[1],
            "Second item does not appear to be a Book instance"
        );
    }

}











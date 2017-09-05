<?php


use App\Database\Statement\SubQuery\Pivot\PivotEquals;

class PivotEqualsTest extends TestCase
{
    /**
     * @test
     */
    public function returns_correct_statement()
    {
        $query = new PivotEquals('author_book', 'book_id', 'author_id');

        $sql = "SELECT `book_id`
                FROM `author_book`
                WHERE `author_id` = ?";

        $this->assertEquals(
            $this->trimWhiteSpace($sql),
            $this->trimWhiteSpace($query->query()),
            "PivotEquals::query() returned invalid statement"
        );
    }
}
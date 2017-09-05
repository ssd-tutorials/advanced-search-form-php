<?php


use App\Database\Statement\SubQuery\Pivot\Exists\PivotExistsIn;

class PivotExistsInTest extends TestCase
{
    /**
     * @test
     */
    public function returns_correct_statement()
    {
        $query = new PivotExistsIn(
            'author_book', 'book_id', 'author_id', 'books.id'
        );

        $sql = "SELECT `book_id`
                FROM `author_book`
                WHERE `author_id` IN ?
                AND `book_id` = `books`.`id`";

        $this->assertEquals(
            $this->trimWhiteSpace($sql),
            $this->trimWhiteSpace($query->query()),
            "PivotExistsIn::query() returned invalid statement"
        );
    }
}
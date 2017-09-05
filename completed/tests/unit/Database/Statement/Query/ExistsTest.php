<?php


use App\Database\Concat\ConcatAnd;
use App\Database\Concat\ConcatOr;
use App\Database\Filter;
use App\Database\Statement\Query\Exists;
use App\Database\Statement\SubQuery\Pivot\Exists\PivotExistsEquals;
use App\Database\Statement\SubQuery\Pivot\Exists\PivotExistsIn;

class ExistsTest extends TestCase
{
    /**
     * @test
     */
    public function returns_correct_statement()
    {
        $query = new Exists(
            'books.id',
            new PivotExistsIn(
                'author_book',
                'book_id',
                'author_id',
                'books.id'
            ),
            true
        );

        $sql = "EXISTS (
                    SELECT `book_id`
                    FROM `author_book`
                    WHERE `author_id` IN (1)
                    AND `book_id` = `books`.`id`
                )";

        $this->assertEquals(
            $this->trimWhiteSpace($sql),
            $this->trimWhiteSpace($query->statement([1])),
            "Exists:statement() with sub-query returned incorrect statement"
        );

        $sql = "EXISTS (
                    SELECT `book_id`
                    FROM `author_book`
                    WHERE `author_id` IN ?
                    AND `book_id` = `books`.`id`
                )";

        $this->assertEquals(
            $this->trimWhiteSpace($sql),
            $this->trimWhiteSpace($query->statement(1)),
            "Exists:statement() with sub-query returned incorrect statement"
        );
    }

    /**
     * @test
     */
    public function returns_correct_boolean_for_has_sub_query()
    {
        $query = new Exists('books.id');

        $this->assertFalse(
            $query->hasSubQuery(),
            "Exists::hasSubQuery() returned true"
        );

        $query = new Exists(
            'books.id',
            new PivotExistsIn(
                'author_book',
                'book_id',
                'author_id',
                'books.id'
            )
        );

        $this->assertTrue(
            $query->hasSubQuery(),
            "Exists::hasSubQuery() returned false"
        );
    }

    /**
     * @test
     */
    public function returns_correct_boolean_for_replace_sub_query()
    {
        $query = new Exists('books.id');

        $this->assertFalse(
            $query->replaceSubQuery(),
            "Exists::replaceSubQuery() returned true"
        );

        $query = new Exists(
            'books.id',
            new PivotExistsIn(
                'author_book',
                'book_id',
                'author_id',
                'books.id'
            ),
            true
        );

        $this->assertTrue(
            $query->replaceSubQuery(),
            "Exists::replaceSubQuery() returned false"
        );
    }

    /**
     * @test
     */
    public function returns_correct_value()
    {
        $query = new Exists('books.id');

        $this->assertEquals(
            1,
            $query->value(1),
            "Exists::value() returned incorrect value"
        );

        $query = new Exists(
            'books.id',
            new PivotExistsIn(
                'author_book',
                'book_id',
                'author_id',
                'books.id'
            ),
            true
        );

        $this->assertEquals(
            "(0, 0)",
            $query->value(['first value', 'second value']),
            "Exists:value() returned incorrect value for sub-query replacement with array of string"
        );

        $this->assertEquals(
            "(2, 18)",
            $query->value([2, 18]),
            "Exists:value() returned incorrect value for sub-query replacement with array of integers"
        );
    }

    /**
     * @test
     */
    public function filter_does_not_return_values_with_sub_query_replace()
    {
        $filter = new Filter(
            [
                new Exists(
                    'books.id',
                    new PivotExistsIn(
                        'book_location',
                        'book_id',
                        'location_id',
                        'books.id'
                    ),
                    true
                )
            ],
            new ConcatAnd
        );

        $this->assertCount(
            0,
            $filter->filter([1, 2])->values(),
            "Number of values with sub-query replace is not 0"
        );
    }

    /**
     * @test
     */
    public function filter_returns_correct_number_of_values()
    {
        $filter = new Filter(
            [
                new Exists(
                    'books.id',
                    new PivotExistsIn(
                        'book_location',
                        'book_id',
                        'location_id',
                        'books.id'
                    )
                )
            ],
            new ConcatAnd
        );

        $this->assertCount(
            1,
            $filter->filter(1)->values(),
            "Number of values with sub-query replace is not 1"
        );
    }

    /**
     * @test
     */
    public function filter_returns_correct_value()
    {
        $filter = new Filter(
            [
                new Exists(
                    'books.id',
                    new PivotExistsIn(
                        'book_location',
                        'book_id',
                        'location_id',
                        'books.id'
                    )
                )
            ],
            new ConcatAnd
        );

        $this->assertEquals(
            [5],
            $filter->filter(5)->values(),
            "Incorrect values returned with argument 5"
        );
    }

    /**
     * @test
     */
    public function filter_produces_correct_statement_with_outer_and()
    {
        $filterEquals = new Filter(
            [
                new Exists(
                    'books.id',
                    new PivotExistsEquals(
                        'author_book',
                        'book_id',
                        'author_id',
                        'books.id'
                    )
                )
            ],
            new ConcatAnd,
            new ConcatAnd
        );

        $filterIn = new Filter(
            [
                new Exists(
                    'books.id',
                    new PivotExistsIn(
                        'author_book',
                        'book_id',
                        'author_id',
                        'books.id'
                    ),
                    true
                )
            ],
            new ConcatAnd,
            new ConcatAnd
        );

        $filterEquals->filter(5);
        $filterIn->filter([2, 5]);

        $sql = "EXISTS (
                    SELECT `book_id`
                    FROM `author_book`
                    WHERE `author_id` = ?
                    AND `book_id` = `books`.`id`
                )";

        $this->assertEquals(
            $this->trimWhiteSpace($sql),
            $this->trimWhiteSpace($filterEquals->statement(true)),
            "Incorrect statement with outer AND, inner AND and first statement"
        );

        $sql = "AND EXISTS (
                    SELECT `book_id`
                    FROM `author_book`
                    WHERE `author_id` = ?
                    AND `book_id` = `books`.`id`
                )";

        $this->assertEquals(
            $this->trimWhiteSpace($sql),
            $this->trimWhiteSpace($filterEquals->statement()),
            "Incorrect statement with outer AND, inner AND and non first statement"
        );

        $sql = "EXISTS (
                    SELECT `book_id`
                    FROM `author_book`
                    WHERE `author_id` IN (2, 5)
                    AND `book_id` = `books`.`id`
                )";

        $this->assertEquals(
            $this->trimWhiteSpace($sql),
            $this->trimWhiteSpace($filterIn->statement(true)),
            "Incorrect statement with outer AND, inner AND (PivotExistsIn) and first statement"
        );

        $sql = "AND EXISTS (
                    SELECT `book_id`
                    FROM `author_book`
                    WHERE `author_id` IN (2, 5)
                    AND `book_id` = `books`.`id`
                )";

        $this->assertEquals(
            $this->trimWhiteSpace($sql),
            $this->trimWhiteSpace($filterIn->statement()),
            "Incorrect statement with outer AND, inner AND (PivotExistsIn) and non first statement"
        );
    }

    /**
     * @test
     */
    public function filter_produces_correct_statement_with_outer_or()
    {
        $filter = new Filter(
            [
                new Exists(
                    'books.id',
                    new PivotExistsEquals(
                        'author_book',
                        'book_id',
                        'author_id',
                        'books.id'
                    )
                )
            ],
            new ConcatOr,
            new ConcatAnd
        );

        $filter->filter(5);

        $sql = "OR EXISTS (
                    SELECT `book_id`
                    FROM `author_book`
                    WHERE `author_id` = ?
                    AND `book_id` = `books`.`id`
                )";

        $this->assertEquals(
            $this->trimWhiteSpace($sql),
            $this->trimWhiteSpace($filter->statement()),
            "Incorrect statement with outer OR and inner AND"
        );
    }

    /**
     * @test
     */
    public function filter_produces_correct_statement_with_outer_or_and_sub_query_replacement()
    {
        $filter = new Filter(
            [
                new Exists(
                    'books.id',
                    new PivotExistsIn(
                        'author_book',
                        'book_id',
                        'author_id',
                        'books.id'
                    ),
                    true
                )
            ],
            new ConcatOr,
            new ConcatAnd
        );

        $filter->filter([2, 5]);

        $sql = "OR EXISTS (
                    SELECT `book_id`
                    FROM `author_book`
                    WHERE `author_id` IN (2, 5)
                    AND `book_id` = `books`.`id`
                )";

        $this->assertEquals(
            $this->trimWhiteSpace($sql),
            $this->trimWhiteSpace($filter->statement()),
            "Incorrect statement with outer OR and inner AND (PivotExistsIn)"
        );
    }
}
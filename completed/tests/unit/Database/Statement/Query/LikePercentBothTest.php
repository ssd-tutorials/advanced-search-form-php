<?php

use App\Database\Concat\ConcatAnd;
use App\Database\Concat\ConcatAndWrap;
use App\Database\Concat\ConcatOr;
use App\Database\Concat\ConcatOrWrap;
use App\Database\Filter;
use App\Database\Statement\Query\LikePercentBoth;
use App\Database\Statement\SubQuery\Pivot\Exists\PivotExistsEquals;

class LikePercentBothTest extends TestCase
{
    /**
     * @test
     */
    public function returns_correct_statement()
    {
        $query = new LikePercentBoth('books.title');

        $this->assertEquals(
            "`books`.`title` LIKE ?",
            $this->trimWhiteSpace($query->statement(1)),
            "LikePercentBoth::statement() returned incorrect statement"
        );
    }

    /**
     * @test
     */
    public function returns_correct_boolean_for_has_sub_query()
    {
        $query = new LikePercentBoth('books.title');

        $this->assertFalse(
            $query->hasSubQuery(),
            "LikePercentBoth::hasSubQuery() returned true"
        );

        $query = new LikePercentBoth(
            'books.title',
            new PivotExistsEquals(
                'author_books',
                'book_id',
                'author_id',
                'books.id'
            )
        );

        $this->assertTrue(
            $query->hasSubQuery(),
            "LikePercentBoth::hasSubQuery() returned false"
        );
    }

    /**
     * @test
     */
    public function returns_correct_boolean_for_replace_sub_query()
    {
        $query = new LikePercentBoth('books.title');

        $this->assertFalse(
            $query->replaceSubQuery(),
            "LikePercentBoth::replaceSubQuery() returned true"
        );

        $query = new LikePercentBoth(
            'books.title',
            new PivotExistsEquals(
                'author_books',
                'book_id',
                'author_id',
                'books.id'
            ),
            true
        );

        $this->assertTrue(
            $query->replaceSubQuery(),
            "LikePercentBoth::replaceSubQuery() returned false"
        );
    }

    /**
     * @test
     */
    public function returns_correct_value()
    {
        $query = new LikePercentBoth('books.id');

        $this->assertEquals(
            "%1%",
            $query->value(1),
            "LikePercentBoth::value() returned incorrect value"
        );

        $query = new LikePercentBoth(
            'books.id',
            new PivotExistsEquals(
                'author_book',
                'book_id',
                'author_id',
                'books.id'
            ),
            true
        );

        $this->assertEquals(
            "%Book%",
            $query->value('Book'),
            "LikePercentBoth::value() returned incorrect value for sub-query replacement with string"
        );

        $this->assertEquals(
            "%(2, 10)%",
            $query->value([2, 10]),
            "LikePercentBoth::value() returned incorrect value for sub-query replacement with array"
        );
    }

    /**
     * @test
     */
    public function filter_returns_correct_values()
    {
        $filter = new Filter(
            [
                new LikePercentBoth('books.title'),
                new LikePercentBoth('books.description')
            ],
            new ConcatAnd,
            new ConcatOr
        );

        $this->assertCount(
            2,
            $filter->filter('Twiglight')->values(),
            "Filter returned incorrect number of values"
        );

        $this->assertSame(
            ['%Twiglight%', '%Twiglight%'],
            $filter->filter('Twiglight')->values(),
            "Filter returned incorrect values"
        );
    }

    /**
     * @test
     */
    public function filter_produces_correct_statement_with_multiple_queries_outer_and_and_inner_or()
    {
        $filter = new Filter(
            [
                new LikePercentBoth('books.title'),
                new LikePercentBoth('books.description')
            ],
            new ConcatAnd,
            new ConcatOr
        );

        $filter->filter('Twiglight');

        $this->assertEquals(
            "`books`.`title` LIKE ? OR `books`.`description` LIKE ?",
            $this->trimWhiteSpace($filter->statement(true)),
            "Incorrect statement with outer AND and inner OR as first statement"
        );

        $this->assertEquals(
            "AND `books`.`title` LIKE ? OR `books`.`description` LIKE ?",
            $this->trimWhiteSpace($filter->statement()),
            "Incorrect statement with outer AND and inner OR as non first statement"
        );
    }

    /**
     * @test
     */
    public function filter_produces_correct_statement_with_multiple_queries_outer_and_wrap_and_inner_or()
    {
        $filter = new Filter(
            [
                new LikePercentBoth('books.title'),
                new LikePercentBoth('books.description')
            ],
            new ConcatAndWrap,
            new ConcatOr
        );

        $filter->filter('Twiglight');

        $this->assertEquals(
            "(`books`.`title` LIKE ? OR `books`.`description` LIKE ?)",
            $this->trimWhiteSpace($filter->statement(true)),
            "Incorrect statement with outer AND WRAP and inner OR as first statement"
        );

        $this->assertEquals(
            "AND (`books`.`title` LIKE ? OR `books`.`description` LIKE ?)",
            $this->trimWhiteSpace($filter->statement()),
            "Incorrect statement with outer AND WRAP and inner OR as non first statement"
        );
    }

    /**
     * @test
     */
    public function filter_produces_correct_statement_with_multiple_queries_outer_or_and_inner_and()
    {
        $filter = new Filter(
            [
                new LikePercentBoth('books.title'),
                new LikePercentBoth('books.description')
            ],
            new ConcatOr,
            new ConcatAnd
        );

        $filter->filter('Twiglight');

        $this->assertEquals(
            "`books`.`title` LIKE ? AND `books`.`description` LIKE ?",
            $this->trimWhiteSpace($filter->statement(true)),
            "Incorrect statement with outer OR and inner AND as first statement"
        );

        $this->assertEquals(
            "OR `books`.`title` LIKE ? AND `books`.`description` LIKE ?",
            $this->trimWhiteSpace($filter->statement()),
            "Incorrect statement with outer OR and inner AND as non first statement"
        );
    }

    /**
     * @test
     */
    public function filter_produces_correct_statement_with_multiple_queries_outer_or_wrap_and_inner_and()
    {
        $filter = new Filter(
            [
                new LikePercentBoth('books.title'),
                new LikePercentBoth('books.description')
            ],
            new ConcatOrWrap,
            new ConcatAnd
        );

        $filter->filter('Twiglight');

        $this->assertEquals(
            "(`books`.`title` LIKE ? AND `books`.`description` LIKE ?)",
            $this->trimWhiteSpace($filter->statement(true)),
            "Incorrect statement with outer OR WRAP and inner AND as first statement"
        );

        $this->assertEquals(
            "OR (`books`.`title` LIKE ? AND `books`.`description` LIKE ?)",
            $this->trimWhiteSpace($filter->statement()),
            "Incorrect statement with outer OR WRAP and inner AND as non first statement"
        );
    }
}




















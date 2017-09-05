<?php

use App\Database\Concat\ConcatAnd;
use App\Database\Concat\ConcatAndWrap;
use App\Database\Concat\ConcatOr;
use App\Database\Concat\ConcatOrWrap;

use App\Database\Filter;
use App\Database\Statement\Query\Equals;
use App\Database\Statement\SubQuery\Pivot\PivotEquals;

class EqualsTest extends TestCase
{
    /**
     * @test
     */
    public function returns_correct_statement()
    {
        $query = new Equals('books.id');

        $this->assertEquals(
            "`books`.`id` = ?",
            $this->trimWhiteSpace($query->statement(1)),
            "Equals::statement() without sub-query returned incorrect statement"
        );
    }

    /**
     * @test
     */
    public function returns_correct_boolean_for_has_sub_query()
    {
        $query = new Equals('books.id');

        $this->assertFalse(
            $query->hasSubQuery(),
            "Equals::hasSubQuery() returned true"
        );

        $query = new Equals(
            'books.id',
            new PivotEquals(
                'author_book',
                'book_id',
                'author_id',
                'books.id'
            )
        );

        $this->assertTrue(
            $query->hasSubQuery(),
            "Equals::hasSubQuery() returned false"
        );
    }

    /**
     * @test
     */
    public function returns_correct_boolean_for_replace_sub_query()
    {
        $query = new Equals('books.id');

        $this->assertFalse(
            $query->replaceSubQuery(),
            "Equals::replaceSubQuery() returned true"
        );

        $query = new Equals(
            'books.id',
            new PivotEquals(
                'author_book',
                'book_id',
                'author_id',
                'books.id'
            ),
            true
        );

        $this->assertTrue(
            $query->replaceSubQuery(),
            "Equals::replaceSubQuery() returned false"
        );
    }

    /**
     * @test
     */
    public function returns_correct_value()
    {
        $query = new Equals('books.id');

        $this->assertEquals(
            1,
            $query->value(1),
            "Equals::value() returned incorrect value"
        );

        $query = new Equals(
            'books.id',
            new PivotEquals(
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
            "Equals::value() returned incorrect value for sub-query replacement with array of strings"
        );

        $this->assertEquals(
            "(2, 18)",
            $query->value([2, 18]),
            "Equals::value() returned incorrect value for sub-query replacement with array of integers"
        );
    }

    /**
     * @test
     */
    public function filter_returns_correct_number_of_values()
    {
        $filter = new Filter(
            [
                new Equals('books.id'),
                new Equals('books.category')
            ],
            new ConcatAnd,
            new ConcatOr
        );

        $this->assertCount(
            2,
            $filter->filter('Twiglight')->values(),
            "Incorrect number of values"
        );
    }

    /**
     * @test
     */
    public function filter_returns_correct_values()
    {
        $filter = new Filter(
            [
                new Equals('books.id'),
                new Equals('books.category')
            ],
            new ConcatAnd,
            new ConcatOr
        );

        $this->assertEquals(
            [5, 5],
            $filter->filter(5)->values(),
            "Incorrect filtered values"
        );
    }

    /**
     * @test
     */
    public function filter_produces_correct_statement_with_multiple_queries_and_with_outer_and_and_inner_or()
    {
        $filter = new Filter(
            [
                new Equals('books.id'),
                new Equals('books.category')
            ],
            new ConcatAnd,
            new ConcatOr
        );

        $filter->filter(5);

        $this->assertEquals(
            "`books`.`id` = ? OR `books`.`category` = ?",
            $filter->statement(true),
            "Incorrect statement with outer AND and inner OR with first statement"
        );

        $this->assertEquals(
            "AND `books`.`id` = ? OR `books`.`category` = ?",
            $filter->statement(),
            "Incorrect statement with outer AND and inner OR without first statement"
        );
    }

    /**
     * @test
     */
    public function filter_produces_correct_statement_with_multiple_queries_and_with_outer_and_wrap_and_inner_or()
    {
        $filter = new Filter(
            [
                new Equals('books.id'),
                new Equals('books.category')
            ],
            new ConcatAndWrap,
            new ConcatOr
        );

        $filter->filter('Twiglight');

        $this->assertEquals(
            "(`books`.`id` = ? OR `books`.`category` = ?)",
            $filter->statement(true),
            "Incorrect statement with outer AND WRAP and inner OR with first statement"
        );

        $this->assertEquals(
            "AND (`books`.`id` = ? OR `books`.`category` = ?)",
            $filter->statement(),
            "Incorrect statement with outer AND WRAP and inner OR without first statement"
        );
    }

    /**
     * @test
     */
    public function filter_produces_correct_statement_with_multiple_queries_and_with_outer_or_and_inner_and()
    {
        $filter = new Filter(
            [
                new Equals('books.id'),
                new Equals('books.category')
            ],
            new ConcatOr,
            new ConcatAnd
        );

        $filter->filter('Twiglight');

        $this->assertEquals(
            "`books`.`id` = ? AND `books`.`category` = ?",
            $filter->statement(true),
            "Incorrect statement with outer OR and inner AND with first statement"
        );

        $this->assertEquals(
            "OR `books`.`id` = ? AND `books`.`category` = ?",
            $filter->statement(),
            "Incorrect statement with outer OR and inner AND without first statement"
        );
    }

    /**
     * @test
     */
    public function filter_produces_correct_statement_with_multiple_queries_and_with_outer_or_wrap_and_inner_and()
    {
        $filter = new Filter(
            [
                new Equals('books.id'),
                new Equals('books.category')
            ],
            new ConcatOrWrap,
            new ConcatAnd
        );

        $filter->filter('Twiglight');

        $this->assertEquals(
            "(`books`.`id` = ? AND `books`.`category` = ?)",
            $filter->statement(true),
            "Incorrect statement with outer OR WRAP and inner AND with first statement"
        );

        $this->assertEquals(
            "OR (`books`.`id` = ? AND `books`.`category` = ?)",
            $filter->statement(),
            "Incorrect statement with outer OR WRAP and inner AND without first statement"
        );
    }
}
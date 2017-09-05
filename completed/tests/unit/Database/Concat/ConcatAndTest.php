<?php

use App\Database\Concat\ConcatAnd;

class ConcatAndTest extends TestCase
{
    /**
     * @var ConcatAnd
     */
    private $concat;

    /**
     * Set up before each test.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->concat = new ConcatAnd;
    }

    /**
     * @test
     */
    public function concat_and_with_concat()
    {
        $this->assertEquals(
            "AND `books`.`id` = ?",
            $this->concat->concat("`books`.`id` = ?"),
            "Invalid result for ConcatAnd::concat"
        );
    }

    /**
     * @test
     */
    public function concat_and_with_concat_first()
    {
        $this->assertEquals(
            "`books`.`id` = ?",
            $this->concat->concatFirst("`books`.`id` = ?"),
            "Invalid result for ConcatAnd::concatFirst"
        );
    }
}
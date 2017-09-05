<?php

use App\Database\Concat\ConcatAndWrap;

class ConcatAndWrapTest extends TestCase
{
    /**
     * @var ConcatAndWrap
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

        $this->concat = new ConcatAndWrap;
    }

    /**
     * @test
     */
    public function concat_and_wrap_with_concat()
    {
        $this->assertEquals(
            "AND (`books`.`id` = ?)",
            $this->concat->concat("`books`.`id` = ?"),
            "Invalid result for ConcatAndWrap::concat"
        );
    }

    /**
     * @test
     */
    public function concat_and_wrap_with_concat_first()
    {
        $this->assertEquals(
            "(`books`.`id` = ?)",
            $this->concat->concatFirst("`books`.`id` = ?"),
            "Invalid result for ConcatAndWrap::concatFirst"
        );
    }

}
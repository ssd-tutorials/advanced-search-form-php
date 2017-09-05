<?php

use App\Database\Concat\ConcatOrWrap;

class ConcatOrWrapTest extends TestCase
{
    /**
     * @var ConcatOrWrap
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

        $this->concat = new ConcatOrWrap;
    }

    /**
     * @test
     */
    public function concat_or_wrap_with_concat()
    {
        $this->assertEquals(
            "OR (`books`.`id` = ?)",
            $this->concat->concat("`books`.`id` = ?"),
            "Invalid result for ConcatOrWrap::concat"
        );
    }

    /**
     * @test
     */
    public function concat_or_wrap_with_concat_first()
    {
        $this->assertEquals(
            "(`books`.`id` = ?)",
            $this->concat->concatFirst("`books`.`id` = ?"),
            "Invalid result for ConcatOrWrap::concatFirst"
        );
    }
}
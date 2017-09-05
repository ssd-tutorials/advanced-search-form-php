<?php


use App\Helper;

class HelperTest extends TestCase
{
    /**
     * @test
     */
    public function correctly_returns_singular_and_plural()
    {
        $this->assertEquals(
            'Books',
            Helper::pluralSingular('Book', 2),
            "Did not return word in plural"
        );

        $this->assertEquals(
            'Book',
            Helper::pluralSingular('Book', 1),
            "Did not return word in singular"
        );
    }
}
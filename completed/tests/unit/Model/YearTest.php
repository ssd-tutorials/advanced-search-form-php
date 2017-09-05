<?php

use App\Model\Book;
use App\Model\Year;

class YearTest extends ModelCase
{
    use ModelData;

    /**
     * @test
     */
    public function returns_correct_years_collection()
    {
        $book = new Book;

        $book->create($this->bookData(['year' => 2016]));
        $book->create($this->bookData(['year' => 2017]));
        $book->create($this->bookData(['year' => 2018]));
        $book->create($this->bookData(['year' => 2018]));

        $years = (new Year)->years();

        $this->assertCount(
            3,
            $years,
            'Years count did not equal 3'
        );

        $this->assertEquals(
            2016,
            $years[0]->year,
            'Year does not match 2016'
        );

        $this->assertEquals(
            2017,
            $years[1]->year,
            'Year does not match 2017'
        );

        $this->assertEquals(
            2018,
            $years[2]->year,
            'Year does not match 2018'
        );
    }
}











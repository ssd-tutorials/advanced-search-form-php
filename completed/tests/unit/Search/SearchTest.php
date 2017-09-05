<?php

use App\Search\Search;
use Illuminate\Http\Request;

class SearchTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();

        $_GET = [];
    }

    /**
     * @test
     */
    public function collects_non_empty_input()
    {
        $_GET['keyword'] = 'book';
        $_GET['location'] = '';

        $search = new Search(
            Request::capture(),
            [
                'keyword',
                'category',
                'author',
                'location'
            ]
        );

        $this->assertTrue(
            $search->has('keyword'),
            "Search failed to collect non empty input"
        );

        $this->assertFalse(
            $search->has('category'),
            "Search collected empty category"
        );

        $this->assertFalse(
            $search->has('author'),
            "Search collected empty author"
        );

        $this->assertFalse(
            $search->has('location'),
            "Search collected empty location"
        );
    }

    /**
     * @test
     */
    public function checks_if_collection_is_empty()
    {
        $search = new Search(
            Request::capture(),
            [
                'keyword'
            ]
        );

        $this->assertTrue(
            $search->isCollectionEmpty(),
            "Empty collection is not empty"
        );

        $_GET['keyword'] = 'book';

        $search = new Search(
            Request::capture(),
            [
                'keyword'
            ]
        );

        $this->assertFalse(
            $search->isCollectionEmpty(),
            "Non empty collection is empty"
        );
    }

    /**
     * @test
     */
    public function checks_for_an_empty_value()
    {
        $search = new Search(
            Request::capture(),
            [
                'keyword'
            ]
        );

        $this->assertTrue(
            $search->isEmpty(''),
            "Empty string evaluates to not empty"
        );

        $this->assertTrue(
            $search->isEmpty(null),
            "Null evaluates to not empty"
        );

        $this->assertTrue(
            $search->isEmpty(false),
            "False evaluates to not empty"
        );

        $this->assertTrue(
            $search->isEmpty([]),
            "Empty array evaluates to not empty"
        );

        $this->assertFalse(
            $search->isEmpty(0),
            "Zero evaluates to empty"
        );

        $this->assertFalse(
            $search->isEmpty('string'),
            "String evaluates to empty"
        );
    }

    /**
     * @test
     */
    public function value_is_method_returns_correct_boolean()
    {
        $_GET['keyword'] = 'book';

        $search = new Search(
            Request::capture(),
            [
                'keyword',
                'category'
            ]
        );

        $this->assertTrue(
            $search->valueIs('keyword', 'book'),
            "The value is not equal book"
        );

        $this->assertFalse(
            $search->valueIs('category', 'romance'),
            "The value equals romance"
        );
    }

    /**
     * @test
     */
    public function has_method_returns_correct_boolean()
    {
        $_GET['keyword'] = 'book';

        $search = new Search(
            Request::capture(),
            [
                'keyword',
                'category'
            ]
        );

        $this->assertTrue(
            $search->has('keyword'),
            "Has returned false with keyword"
        );

        $this->assertFalse(
            $search->has('category'),
            "Has returned true with category"
        );
    }

    /**
     * @test
     */
    public function can_get_correct_value()
    {
        $_GET['keyword'] = 'book';
        $_GET['category'] = 2;
        $_GET['author'] = 'Ernest Hemingway';

        $search = new Search(
            Request::capture(),
            [
                'keyword',
                'category',
                'author'
            ]
        );

        $this->assertEquals(
            'book',
            $search->get('keyword'),
            "Search does not get correct keyword"
        );

        $this->assertEquals(
            2,
            $search->get('category'),
            "Search does not get correct category"
        );

        $this->assertEquals(
            'Ernest Hemingway',
            $search->get('author'),
            "Search does not get correct author"
        );
    }

    /**
     * @test
     */
    public function can_set_correct_value()
    {
        $search = new Search(
            Request::capture(),
            [
                'keyword'
            ]
        );

        $this->assertNull(
            $search->get('keyword'),
            "Search does not get null for keyword"
        );

        $this->assertNull(
            $search->get('category'),
            "Search does not get null for category"
        );

        $this->assertNull(
            $search->get('author'),
            "Search does not get null for author"
        );

        $search->set('keyword', 'book');
        $search->set('category', 2);
        $search->set('author', 'Ernest Hemingway');

        $this->assertEquals(
            'book',
            $search->get('keyword'),
            "Search does not set correct keyword"
        );

        $this->assertEquals(
            2,
            $search->get('category'),
            "Search does not set correct category"
        );

        $this->assertEquals(
            'Ernest Hemingway',
            $search->get('author'),
            "Search does not set correct author"
        );
    }
}
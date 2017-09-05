<?php

use App\Search\Search;
use App\Search\Sticky;

use Illuminate\Http\Request;

class StickyTest extends TestCase
{
    /**
     * @var Sticky
     */
    private $sticky;

    /**
     * @var Sticky
     */
    private $emptySticky;

    protected function setUp()
    {
        parent::setUp();

        $_GET['keyword'] = 'book';
        $_GET['category'] = 2;
        $_GET['cover_type'] = 1;
        $_GET['language'] = 4;
        $_GET['town'] = [3, 6, 12];

        $search = new Search(
            Request::capture(),
            [
                'keyword',
                'category',
                'cover_type',
                'language',
                'town'
            ]
        );

        $this->sticky = new Sticky($search);

        $_GET = [];

        $emptySearch = new Search(
            Request::capture(),
            [
                'keyword',
                'category',
                'cover_type',
                'language',
                'town'
            ]
        );

        $this->emptySticky = new Sticky($emptySearch);
    }

    /**
     * @test
     */
    public function text_returns_correct_value()
    {
        $this->assertEquals(
            'book',
            $this->sticky->text('keyword'),
            "Text does not return value book"
        );

        $this->assertEquals(
            'default value',
            $this->emptySticky->text('keyword', 'default value'),
            "Text does not return default value"
        );

        $this->assertNull(
            $this->emptySticky->text('keyword'),
            "Text did not return null"
        );
    }

    /**
     * @test
     */
    public function select_correctly_returns_selected_attribute()
    {
        $this->assertEquals(
            ' selected="selected"',
            $this->sticky->select('category', 2),
            "Select does not return selected value 2"
        );

        $this->assertEquals(
            ' selected="selected"',
            $this->emptySticky->select('category', 5, 5),
            "Select does not return selected with default value"
        );

        $this->assertNull(
            $this->emptySticky->select('category', 20),
            "Select does not return null"
        );
    }

    /**
     * @test
     */
    public function radio_button_correctly_returns_checked_attribute()
    {
        $this->assertEquals(
            ' checked="checked"',
            $this->sticky->radio('cover_type', 1),
            "Radio button does not return checked with value 1"
        );

        $this->assertEquals(
            ' checked="checked"',
            $this->emptySticky->radio('cover_type', 2, 2),
            "Radio button does not return checked with default value"
        );

        $this->assertNull(
            $this->emptySticky->radio('cover_type', 20),
            "Radio button does not return null"
        );
    }

    /**
     * @test
     */
    public function single_checkbox_correctly_returns_checked_attribute()
    {
        $this->assertEquals(
            ' checked="checked"',
            $this->sticky->checkbox('language', 4),
            "Single checkbox does not return checked with value 4"
        );

        $this->assertEquals(
            ' checked="checked"',
            $this->emptySticky->checkbox('language', 2, true),
            "Single checkbox does not return checked with checked set to true"
        );

        $this->assertNull(
            $this->emptySticky->checkbox('language', 2),
            "Single checkbox does not return null"
        );
    }

    /**
     * @test
     */
    public function array_of_checkboxes_correctly_returns_checked_attribute()
    {
        $this->assertEquals(
            ' checked="checked"',
            $this->sticky->checkboxArray('town', 3),
            "Array of checkboxes does not return checked with value 3"
        );

        $this->assertEquals(
            ' checked="checked"',
            $this->emptySticky->checkboxArray('town', 2, [2, 10]),
            "Array of checkboxes does not return checked with checked array"
        );

        $this->assertNull(
            $this->emptySticky->checkboxArray('town', 5),
            "Array or checkboxes does not return null"
        );
    }
}



















<?php

use App\Database\Statement\Field;

class FieldTest extends TestCase
{
    /**
     * @test
     */
    public function returns_formatted_field_name()
    {
        $this->assertEquals(
            "`name`",
            Field::fieldName("name"),
            "Incorrectly formatted `name`"
        );

        $this->assertEquals(
            "`books`.`id`",
            Field::fieldName("books.id"),
            "Incorrectly formatted `books`.`id`"
        );

        $this->assertEquals(
            "`books`.`first.name`",
            Field::fieldName("books.first.name"),
            "Incorrectly formatted `books`.`first.name`"
        );
    }
}
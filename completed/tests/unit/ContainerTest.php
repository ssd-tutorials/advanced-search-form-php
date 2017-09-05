<?php

use App\Container;

class ContainerTest extends TestCase
{
    /**
     * @test
     */
    public function binds_single_item()
    {
        Container::bind('date', new DateTime);

        $this->assertInstanceOf(
            DateTime::class,
            Container::get('date'),
            "Container::bind did not bind single item"
        );
    }

    /**
     * @test
     */
    public function binds_multiple_items()
    {
        Container::bind([
            'date' => new DateTime,
            'directory' => new DirectoryIterator(__DIR__)
        ]);

        $this->assertInstanceOf(
            DateTime::class,
            Container::get('date'),
            "Container::bind did not bind multiple items (date)"
        );

        $this->assertInstanceOf(
            DirectoryIterator::class,
            Container::get('directory'),
            "Container::bind did not bind multiple items (directory)"
        );
    }
}
<?php

use App\Container;
use App\Database\DatabaseManager;
use App\Migration\MigrationManager;
use App\Migration\Model\Migration;

abstract class ModelCase extends TestCase
{
    /**
     * Migrate database.
     *
     * @return void
     * @throws Exception
     */
    protected function migrate()
    {
        Container::bind([
            'db' => DatabaseManager::make()
        ]);

        (new MigrationManager(new Migration(Container::get('db'))))->up();
    }

    /**
     * Set up before each test.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->migrate();
    }

    /**
     * Clean up after each test.
     *
     * @return void
     * @throws Exception
     */
    protected function tearDown()
    {
        parent::tearDown();

        (new MigrationManager(new Migration(Container::get('db'))))->down();
    }
}













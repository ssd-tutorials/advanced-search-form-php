<?php

use App\Database\Database;
use App\Database\DatabaseManager;

class DatabaseManagerTest extends TestCase
{
    /**
     * @test 
     */
    public function returns_database_instance()
    {
       $this->assertInstanceOf(
           Database::class,
           DatabaseManager::make(),
           "DatabaseManager::make() did not return instance of Database"
       );
    }
}
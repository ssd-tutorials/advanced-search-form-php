<?php namespace App\Migration;

use App\Database\Driver\MySql;
use App\Database\DatabaseManager;
use App\Migration\Model\Migration;

class MigrationManager
{
    /**
     * @var Migration
     */
    private $migration;

    /**
     * @var array
     */
    private $tables = [
        'authors',
        'categories',
        'covers',
        'languages',
        'locations',
        'books',
        'author_book',
        'book_cover',
        'book_language',
        'book_location'
    ];

    /**
     * Migrate constructor.
     *
     * @param Migration $migration
     */
    public function __construct(Migration $migration)
    {
        $this->migration = $migration;
    }

    /**
     * Create tables.
     *
     * @return void
     */
    public function up()
    {
        $this->disableForeignKeyCheck();

        foreach($this->tables as $table) {
            $this->migration->create($table);
        }

        $this->enableForeignKeyCheck();
    }

    /**
     * Destroy tables.
     *
     * @return void
     */
    public function down()
    {
        $this->disableForeignKeyCheck();

        $tables = array_reverse($this->tables);

        foreach($tables as $table) {
            $this->migration->destroy($table);
        }

        $this->enableForeignKeyCheck();
    }

    /**
     * Disable foreign key check.
     *
     * @return void
     */
    private function disableForeignKeyCheck()
    {
        if ($this->migration->db() instanceof MySql) {
            $this->migration->db()->execute("SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0");
        }
    }

    /**
     * Enable foreign key check.
     *
     * @return void
     */
    private function enableForeignKeyCheck()
    {
        if ($this->migration->db() instanceof MySql) {
            $this->migration->db()->execute("SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS");
        }
    }

    /**
     * Migrate tables.
     *
     * @return void
     */
    public static function migrate()
    {
        (new static(new Migration(DatabaseManager::make())))->up();
    }

    /**
     * Remove tables.
     *
     * @return void
     */
    public static function reset()
    {
        (new static(new Migration(DatabaseManager::make())))->down();
    }
}
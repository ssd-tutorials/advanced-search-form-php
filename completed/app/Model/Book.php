<?php

namespace App\Model;

class Book extends Model
{
    /**
     * @var string
     */
    protected $table = 'books';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $category_id;

    /**
     * @var string
     */
    public $isbn;

    /**
     * @var int
     */
    public $year;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $price;

    /**
     * @var string
     */
    public $category;

    /**
     * @var string
     */
    public $authors;

    /**
     * @var string
     */
    public $languages;

    /**
     * @var string
     */
    public $locations;

    /**
     * @var string
     */
    public $covers;


    /**
     * Sql select statement.
     *
     * @return string
     */
    public function sql()
    {
        return "SELECT `{$this->table}`.*,
                `categories`.`name` AS `category`,
                (
                  SELECT GROUP_CONCAT(`name`)
                  FROM `authors`
                  WHERE `id` IN (
                    SELECT `author_id`
                    FROM `author_book`
                    WHERE `book_id` = `{$this->table}`.`id`
                  )
                ) AS `authors`,
                (
                  SELECT GROUP_CONCAT(`name`)
                  FROM `languages`
                  WHERE `id` IN (
                    SELECT `language_id`
                    FROM `book_language`
                    WHERE `book_id` = `{$this->table}`.`id`
                  )
                ) AS `languages`,
                (
                  SELECT GROUP_CONCAT(`name`)
                  FROM `locations`
                  WHERE `id` IN (
                    SELECT `location_id`
                    FROM `book_location`
                    WHERE `book_id` = `{$this->table}`.`id`
                  )
                ) AS `locations`,
                (
                  SELECT GROUP_CONCAT(`name`)
                  FROM `covers`
                  WHERE `id` IN (
                    SELECT `cover_id`
                    FROM `book_cover`
                    WHERE `book_id` = `{$this->table}`.`id`
                  )
                ) AS `covers`
                FROM `{$this->table}`
                LEFT JOIN `categories`
                  ON `categories`.`id` = `{$this->table}`.`category_id`";
    }

    /**
     * Get list of books.
     *
     * @return array
     */
    public function books()
    {
        return $this->orderBy('title')->all();
    }

    /**
     * Get formatted price.
     *
     * @return string
     */
    public function price()
    {
        return '£' . number_format($this->price, 2);
    }

    /**
     * Get authors concatenated with joint.
     *
     * @param string $joint
     * @return string
     */
    public function authors($joint = ", ")
    {
        return $this->groupConcat($this->authors, $joint);
    }

    /**
     * Sort and concatenate items.
     *
     * @param array $items
     * @param string $joint
     * @return string
     */
    private function sortImplode(array $items, $joint)
    {
        sort($items);
        return implode($joint, $items);
    }

    /**
     * Get string of items concatenated with joint.
     *
     * @param string $string
     * @param string $joint
     * @return string
     */
    private function groupConcat($string, $joint = ", ")
    {
        return $this->sortImplode(
            explode(",", $string),
            $joint
        );
    }

    /**
     * Get languages concatenated by joint.
     *
     * @param string $joint
     * @return string
     */
    public function languages($joint = ", ")
    {
        return $this->groupConcat($this->languages, $joint);
    }

    /**
     * Get locations concatenated by joint.
     *
     * @param string $joint
     * @return string
     */
    public function locations($joint = ", ")
    {
        return $this->groupConcat($this->locations, $joint);
    }

    /**
     * Get covers concatenated by joint.
     *
     * @param string $joint
     * @return string
     */
    public function covers($joint = ", ")
    {
        return $this->groupConcat($this->covers, $joint);
    }

}
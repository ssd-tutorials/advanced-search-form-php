<?php

namespace App\Search;

use Illuminate\Http\Request;

class Search
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var array
     */
    private $expected = [];

    /**
     * @var array
     */
    public $collection = [];

    /**
     * Search constructor.
     *
     * @param Request $request
     * @param array $expected
     */
    public function __construct(Request $request, array $expected)
    {
        $this->request = $request;
        $this->expected = $expected;

        $this->collect();
    }

    /**
     * Collect search criteria.
     *
     * @return void
     */
    private function collect()
    {
        $expected = $this->request->only($this->expected);

        $this->collection = array_filter($expected, function($value) {
            return ! $this->isEmpty($value);
        });
    }

    /**
     * Check if value is empty.
     *
     * @param mixed $value
     * @return bool
     */
    public function isEmpty($value)
    {
        return (
            empty($value) &&
            ! is_numeric($value)
        );
    }

    /**
     * Check if collection is empty.
     *
     * @return bool
     */
    public function isCollectionEmpty()
    {
        return empty($this->collection);
    }

    /**
     * Check if the given input
     * exists in the collection.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->collection);
    }

    /**
     * Check if value is equal $value.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function valueIs($key, $value)
    {
        if ( ! $this->has($key)) {
            return false;
        }

        return $this->collection[$key] == $value;
    }

    /**
     * Get value associated with the key.
     *
     * @param string $key
     * @return mixed|null
     */
    public function get($key)
    {
        if ( ! $this->has($key)) {
            return null;
        }

        return $this->collection[$key];
    }

    /**
     * Set value for a given key.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value)
    {
        $this->collection[$key] = $value;
    }
}
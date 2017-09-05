<?php


namespace App;

use Exception;

class Container
{
    /**
     * @var array
     */
    private static $container = [];

    /**
     * Bind to the container.
     *
     * @param $key
     * @param null $value
     */
    public static function bind($key, $value = null)
    {
        if ( ! is_array($key)) {
            $key = [$key => $value];
        }

        static::bindArray($key);
    }

    /**
     * Bind array to the container.
     *
     * @param array $array
     */
    private static function bindArray(array $array)
    {
        static::$container = array_merge(static::$container, $array);
    }

    /**
     * Get item from the container.
     *
     * @param $key
     * @return mixed
     * @throws Exception
     */
    public static function get($key)
    {
        if ( ! array_key_exists($key, static::$container)) {
            throw new Exception("There is not {$key} bound in the container");
        }

        return static::$container[$key];
    }
}










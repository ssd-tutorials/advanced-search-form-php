<?php

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Trim new lines and multiple white spaces.
     *
     * @param string $string
     * @return string
     */
    protected function trimWhiteSpace($string)
    {
        return trim(
            preg_replace(
                ['/\(\n\s+/', '/\n\s+\)/', '/\n\s+/', '/\s+/'],
                ['(', ')', ' ', ' '],
                $string
            )
        );
    }

    /**
     * Get base url with or without the slash.
     *
     * @param bool $slash
     * @return string
     */
    protected function baseUrl($slash = false)
    {
        return $slash ? $this->baseUrl . '/' : $this->baseUrl;
    }

    /**
     * Get url with the query string.
     *
     * @param array $query
     * @param bool $slash
     * @return string
     */
    protected function urlWithQuery(array $query, $slash = false)
    {
        return $this->baseUrl($slash) . '?' . http_build_query($query);
    }
}
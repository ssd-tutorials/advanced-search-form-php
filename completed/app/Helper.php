<?php

namespace App;

class Helper
{
    /**
     * Get word in singular or plural.
     *
     * @param string $word
     * @param int $number
     * @return string
     */
    public static function pluralSingular($word, $number = 1)
    {
        return (int) $number === 1 ? $word : $word . 's';
    }
}
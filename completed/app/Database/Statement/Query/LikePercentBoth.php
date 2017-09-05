<?php

namespace App\Database\Statement\Query;

class LikePercentBoth extends Query
{
    /**
     * @var string
     */
    protected $operand = 'LIKE';

    /**
     * @var string
     */
    protected $binder = '%$%';
}
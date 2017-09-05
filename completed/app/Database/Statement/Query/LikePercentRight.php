<?php

namespace App\Database\Statement\Query;

class LikePercentRight extends Query
{
    /**
     * @var string
     */
    protected $operand = 'LIKE';

    /**
     * @var string
     */
    protected $binder = '$%';
}
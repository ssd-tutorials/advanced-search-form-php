<?php

namespace App\Database\Statement\Query;

class LikePercentLeft extends Query
{
    /**
     * @var string
     */
    protected $operand = 'LIKE';

    /**
     * @var string
     */
    protected $binder = '%$';
}
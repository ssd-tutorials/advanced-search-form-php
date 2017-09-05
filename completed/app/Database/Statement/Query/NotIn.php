<?php

namespace App\Database\Statement\Query;

class NotIn extends Query
{
    /**
     * @var string
     */
    protected $operand = 'NOT IN';

    /**
     * @var string
     */
    protected $binder = '($)';
}
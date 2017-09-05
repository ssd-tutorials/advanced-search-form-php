<?php

namespace App\Database\Statement\Query;

class In extends Query
{
    /**
     * @var string
     */
    protected $operand = 'IN';

    /**
     * @var string
     */
    protected $binder = '($)';
}
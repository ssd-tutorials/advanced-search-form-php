<?php

namespace App\Database\Statement\SubQuery\Pivot\Exists;

class PivotExistsIn extends PivotExists
{
    /**
     * @var string
     */
    protected $operand = 'IN';
}
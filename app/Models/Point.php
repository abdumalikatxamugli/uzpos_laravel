<?php

namespace App\Models;

use App\Traits\Fabricatable;

class Point extends UuidModel
{
    /**
     * Traits
     */
    use Fabricatable;
     /**
      * Properties
      */
    protected $table = 'uzpos_core_point';
}

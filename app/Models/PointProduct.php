<?php

namespace App\Models;

use App\Traits\Fabricatable;

class PointProduct extends UuidModel
{
    /**
    * Traits
    */
   use Fabricatable;
    /**
     * Properties
     */
   protected $table = 'uzpos_core_pointproduct';
}

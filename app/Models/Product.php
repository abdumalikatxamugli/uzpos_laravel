<?php

namespace App\Models;

use App\Traits\Fabricatable;

class Product extends UuidModel
{
    /**
    * Traits
    */
   use Fabricatable;
    /**
     * Properties
     */
   protected $table = 'uzpos_core_product';
}

<?php

namespace App\Models;

use App\Traits\Fabricatable;

class OrderItem extends UuidModel
{
    /**
    * Traits
    */
   use Fabricatable;
    /**
     * Properties
     */
   protected $table = 'uzpos_sales_orderitem';
}


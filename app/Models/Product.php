<?php

namespace App\Models;

use App\Traits\Fabricatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends UuidModel
{
    /**
    * Traits
    */
   use Fabricatable;
   use HasFactory;
    /**
     * Properties
     */
   protected $table = 'uzpos_core_product';
}

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

   public $timestamps = false;

   /**
    * Relations
    */
    public function product(){
      return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}

